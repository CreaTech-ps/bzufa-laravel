<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\FinancialAuditLog;
use App\Models\FinancialTransaction;
use App\Mail\DonationReceiptMail;
use App\Services\LahzaService;
use App\Services\RecaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    public function __construct(
        private readonly LahzaService $lahzaService,
        private readonly RecaptchaService $recaptchaService,
    ) {
    }

    public function create()
    {
        return view('website.donate', [
            'recaptchaSiteKey' => config('services.recaptcha.site_key'),
        ]);
    }

    public function result(Request $request)
    {
        $reference = (string) $request->query('reference', '');
        $donation = $reference !== '' ? Donation::where('reference_number', $reference)->first() : null;

        return view('website.donate-result', compact('donation'));
    }

    public function receipt(string $reference)
    {
        $donation = Donation::where('reference_number', $reference)->firstOrFail();

        $html = view('website.donation-receipt-pdf', compact('donation'))->render();
        $filename = 'donation-receipt-' . $donation->reference_number . '.pdf';

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)
                ->setPaper('a4')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true);

            return $pdf->download($filename);
        }

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=utf-8',
            'Content-Disposition' => 'inline; filename="' . $filename . '.html"',
        ]);
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => ['nullable', 'string', 'max:255'],
            'donor_email' => ['nullable', 'email', 'max:255'],
            'donor_phone' => ['nullable', 'string', 'max:50'],
            'donor_type' => ['nullable', 'in:individual,institution,anonymous'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency' => ['nullable', 'string', 'max:10'],
            'purpose' => ['nullable', 'in:general,scholarship,project,tribute'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'accept_policies' => ['accepted'],
        ], [
            'accept_policies.accepted' => __('donate.validation_accept_policies'),
        ]);

        if ($this->recaptchaService->isEnabled()) {
            $request->validate([
                'g-recaptcha-response' => ['required', 'string'],
            ], [
                'g-recaptcha-response.required' => __('donate.recaptcha_required'),
            ]);

            if (! $this->recaptchaService->verify($request->input('g-recaptcha-response'), $request->ip())) {
                return back()->withInput()->with('error', __('donate.recaptcha_failed'));
            }
        }

        $validated['currency'] = $validated['currency'] ?? 'ILS';
        $validated['donor_name'] = $validated['donor_name'] ?? 'متبرع إلكتروني';
        $validated['donor_type'] = $validated['donor_type'] ?? 'anonymous';
        if (($validated['purpose'] ?? '') === '') {
            $validated['purpose'] = null;
        }

        $reference = 'DON-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6));
        $donation = Donation::create([
            ...$validated,
            'donation_method' => 'electronic',
            'donation_date' => now()->toDateString(),
            'reference_number' => $reference,
            'status' => 'pending',
            'gateway' => 'lahza',
            'gateway_status' => 'pending',
            'gateway_payload' => [
                'checkout_initiated_at' => now()->toIso8601String(),
            ],
        ]);

        FinancialAuditLog::log('created', $donation, null, $donation->toArray());

        $url = $this->lahzaService->checkoutUrl([
            ...$validated,
            'reference_number' => $reference,
            'success_url' => $this->successUrl($donation),
            'cancel_url' => $this->cancelUrl($donation),
            'callback_url' => route('donate.webhook'),
            'metadata' => [
                'donation_id' => $donation->id,
                'reference_number' => $reference,
            ],
        ]);

        return redirect()->away($url);
    }

    public function callback(Request $request)
    {
        $reference = (string) $request->query('reference', $request->query('reference_number', ''));
        $donation = Donation::where('reference_number', $reference)->first();

        if (! $donation) {
            return redirect()->route('donate.result')->with('error', 'تعذر العثور على عملية التبرع.');
        }

        $payload = [
            'status' => $request->query('status', $request->query('payment_status')),
            'transaction_id' => $request->query('transaction_id', $request->query('id')),
            'reference' => $reference,
            'raw_query' => $request->query(),
        ];

        $this->finalizeDonation($donation, $payload);

        $updatedDonation = $donation->fresh();
        return redirect()->route('donate.result', ['reference' => $updatedDonation?->reference_number]);
    }

    public function webhook(Request $request)
    {
        if (! $this->isValidWebhook($request)) {
            return response()->json(['message' => 'Invalid webhook signature'], 401);
        }

        $payload = $request->all();
        $reference = (string) data_get($payload, 'reference', data_get($payload, 'data.reference', ''));

        if ($reference === '') {
            return response()->json(['message' => 'Missing reference'], 422);
        }

        $donation = Donation::where('reference_number', $reference)->first();
        if (! $donation) {
            return response()->json(['message' => 'Donation not found'], 404);
        }

        $this->finalizeDonation($donation, $payload);

        return response()->json(['message' => 'ok']);
    }

    private function finalizeDonation(Donation $donation, array $payload): void
    {
        $transactionId = (string) data_get($payload, 'transaction_id', data_get($payload, 'id', data_get($payload, 'data.id', '')));
        $verified = $this->lahzaService->verifyTransaction($transactionId);
        $effectivePayload = empty($verified) ? $payload : $verified;

        $status = $this->lahzaService->transactionSucceeded($effectivePayload) ? 'approved' : 'rejected';

        $becameApproved = false;

        DB::transaction(function () use ($donation, $effectivePayload, $transactionId, $status, &$becameApproved): void {
            $donation->refresh();
            if ($donation->status === 'approved') {
                return;
            }

            $oldValues = $donation->toArray();
            $payerName = (string) data_get($effectivePayload, 'customer.name', data_get($effectivePayload, 'data.customer.name', ''));
            $payerEmail = (string) data_get($effectivePayload, 'customer.email', data_get($effectivePayload, 'data.customer.email', ''));
            $payerPhone = (string) data_get($effectivePayload, 'customer.phone', data_get($effectivePayload, 'data.customer.phone', ''));

            $donation->update([
                'status' => $status,
                'reviewed_at' => now(),
                'rejection_reason' => $status === 'rejected' ? 'تعذر تأكيد عملية الدفع الإلكتروني.' : null,
                'donor_name' => $donation->donor_name === 'متبرع إلكتروني' && $payerName !== '' ? $payerName : $donation->donor_name,
                'donor_email' => $donation->donor_email ?: ($payerEmail !== '' ? $payerEmail : null),
                'donor_phone' => $donation->donor_phone ?: ($payerPhone !== '' ? $payerPhone : null),
                'gateway_status' => (string) data_get($effectivePayload, 'status', data_get($effectivePayload, 'data.status', $status)),
                'gateway_transaction_id' => $transactionId !== '' ? $transactionId : $donation->gateway_transaction_id,
                'gateway_payload' => $effectivePayload,
            ]);
            FinancialAuditLog::log($status === 'approved' ? 'approved' : 'rejected', $donation, $oldValues, $donation->toArray());

            if ($status !== 'approved') {
                return;
            }

            $becameApproved = true;

            $exists = FinancialTransaction::query()
                ->where('reference_type', Donation::class)
                ->where('reference_id', $donation->id)
                ->exists();

            if ($exists) {
                return;
            }

            $transaction = FinancialTransaction::create([
                'type' => 'donation_income',
                'amount' => $donation->amount,
                'currency' => $donation->currency,
                'transaction_date' => $donation->donation_date ?? now()->toDateString(),
                'beneficiary_name' => $donation->donor_name,
                'beneficiary_type' => 'other',
                'purpose' => 'تبرع إلكتروني عبر Lahza (' . $donation->reference_number . ')',
                'reference_type' => Donation::class,
                'reference_id' => $donation->id,
                'payment_method' => 'electronic_gateway',
                'bank_reference' => $donation->gateway_transaction_id ?? $donation->reference_number,
                'status' => 'completed',
                'approved_at' => now(),
                'approved_by' => null,
                'created_by' => null,
            ]);
            FinancialAuditLog::log('created', $transaction, null, $transaction->toArray());
        });

        if ($becameApproved) {
            $this->sendBuyerReceiptEmailIfNeeded($donation->fresh());
        }
    }

    private function sendBuyerReceiptEmailIfNeeded(Donation $donation): void
    {
        $email = $donation->donor_email;
        if ($email === null || $email === '') {
            return;
        }

        $payload = is_array($donation->gateway_payload) ? $donation->gateway_payload : [];
        if (! empty($payload['buyer_receipt_email_sent'])) {
            return;
        }

        try {
            $storeName = (string) config('app.name');
            $cardBrand = $this->cardBrandFromGatewayPayload($payload);
            Mail::to($email)
                ->locale((string) config('app.locale', 'ar'))
                ->send(new DonationReceiptMail($donation, $storeName, $cardBrand));

            $merged = array_merge($payload, [
                'buyer_receipt_email_sent' => true,
                'buyer_receipt_email_sent_at' => now()->toIso8601String(),
            ]);
            $donation->update(['gateway_payload' => $merged]);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    private function cardBrandFromGatewayPayload(array $payload): ?string
    {
        $brand = data_get($payload, 'card.brand')
            ?? data_get($payload, 'data.card.brand')
            ?? data_get($payload, 'payment.card.brand')
            ?? data_get($payload, 'payment_method.card.brand')
            ?? data_get($payload, 'payment_method_details.card.brand')
            ?? data_get($payload, 'source.brand')
            ?? data_get($payload, 'data.payment_method.card.brand');

        if (! is_string($brand) || $brand === '') {
            return null;
        }

        return strtoupper($brand);
    }

    private function isValidWebhook(Request $request): bool
    {
        $secret = (string) config('services.lahza.webhook_secret', '');
        if ($secret === '') {
            return true;
        }

        $headerSecret = (string) $request->header('X-Webhook-Secret', '');
        if ($headerSecret !== '' && hash_equals($secret, $headerSecret)) {
            return true;
        }

        $signature = (string) $request->header('X-Lahza-Signature', '');
        if ($signature === '') {
            return false;
        }

        $expected = hash_hmac('sha256', (string) $request->getContent(), $secret);
        return hash_equals($expected, $signature);
    }

    private function successUrl(Donation $donation): string
    {
        return (string) (config('services.lahza.success_url')
            ?: route('donate.callback', ['reference' => $donation->reference_number, 'status' => 'success'], true));
    }

    private function cancelUrl(Donation $donation): string
    {
        return (string) (config('services.lahza.cancel_url')
            ?: route('donate.callback', ['reference' => $donation->reference_number, 'status' => 'failed'], true));
    }
}
