<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LahzaService
{
    public function checkoutUrl(array $payload): string
    {
        $customPaymentPageUrl = trim((string) config('services.lahza.payment_page_url', ''));
        if ($customPaymentPageUrl !== '') {
            $base = rtrim($customPaymentPageUrl, '/');
        } else {
            $base = rtrim((string) config('services.lahza.checkout_url', 'https://pay.lahza.io'), '/');
            $pageId = trim((string) config('services.lahza.page_id', ''));
            if ($pageId !== '') {
                $base .= '/' . $pageId;
            }
        }

        $query = array_filter([
            'amount' => $payload['amount'] ?? null,
            'currency' => $payload['currency'] ?? null,
            'customer_name' => $payload['donor_name'] ?? null,
            'customer_email' => $payload['donor_email'] ?? null,
            'customer_phone' => $payload['donor_phone'] ?? null,
            'reference' => $payload['reference_number'] ?? null,
            'success_url' => $payload['success_url'] ?? null,
            'cancel_url' => $payload['cancel_url'] ?? null,
            'return_url' => $payload['success_url'] ?? null,
            'callback_url' => $payload['callback_url'] ?? null,
            'metadata' => isset($payload['metadata']) ? json_encode($payload['metadata']) : null,
        ], fn ($value) => $value !== null && $value !== '');

        return $base . (count($query) ? ('?' . http_build_query($query)) : '');
    }

    public function verifyTransaction(?string $transactionId): array
    {
        if (! $transactionId) {
            return [];
        }

        $apiBase = rtrim((string) config('services.lahza.api_base_url', ''), '/');
        $secret = (string) config('services.lahza.secret_key', '');

        if ($apiBase === '' || $secret === '') {
            return [];
        }

        try {
            $response = Http::withToken($secret)
                ->acceptJson()
                ->get($apiBase . '/v1/transactions/' . $transactionId);

            if (! $response->successful()) {
                return [];
            }

            return Arr::wrap($response->json());
        } catch (\Throwable) {
            return [];
        }
    }

    public function transactionSucceeded(array $payload): bool
    {
        $status = Str::lower((string) data_get($payload, 'status', data_get($payload, 'data.status', '')));
        $paid = data_get($payload, 'paid', data_get($payload, 'data.paid'));

        return in_array($status, ['success', 'succeeded', 'paid', 'completed'], true) || $paid === true;
    }
}
