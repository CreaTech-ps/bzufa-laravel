<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\PaymentGatewaySetting;
use App\Services\PaymentGatewayConfig;
use Illuminate\Http\Request;

class PaymentGatewaySettingsController extends Controller
{
    public function __construct(
        private readonly PaymentGatewayConfig $gatewayConfig,
    ) {
    }

    public function edit()
    {
        $settings = PaymentGatewaySetting::get();
        $activeMode = $this->gatewayConfig->activeMode();
        $resolved = $this->gatewayConfig->lahza();
        $webhookUrl = route('donate.webhook');

        return view('cp.payment-gateway.edit', compact('settings', 'activeMode', 'resolved', 'webhookUrl'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'donations_enabled' => ['nullable', 'boolean'],
            'active_mode' => ['required', 'in:test,live'],
            'test_credentials' => ['nullable', 'array'],
            'test_credentials.public_key' => ['nullable', 'string', 'max:500'],
            'test_credentials.secret_key' => ['nullable', 'string', 'max:500'],
            'test_credentials.page_id' => ['nullable', 'string', 'max:255'],
            'test_credentials.payment_page_url' => ['nullable', 'url', 'max:500'],
            'test_credentials.webhook_secret' => ['nullable', 'string', 'max:500'],
            'test_credentials.checkout_url' => ['nullable', 'url', 'max:500'],
            'test_credentials.api_base_url' => ['nullable', 'url', 'max:500'],
            'test_credentials.success_url' => ['nullable', 'url', 'max:500'],
            'test_credentials.cancel_url' => ['nullable', 'url', 'max:500'],
            'live_credentials' => ['nullable', 'array'],
            'live_credentials.public_key' => ['nullable', 'string', 'max:500'],
            'live_credentials.secret_key' => ['nullable', 'string', 'max:500'],
            'live_credentials.page_id' => ['nullable', 'string', 'max:255'],
            'live_credentials.payment_page_url' => ['nullable', 'url', 'max:500'],
            'live_credentials.webhook_secret' => ['nullable', 'string', 'max:500'],
            'live_credentials.checkout_url' => ['nullable', 'url', 'max:500'],
            'live_credentials.api_base_url' => ['nullable', 'url', 'max:500'],
            'live_credentials.success_url' => ['nullable', 'url', 'max:500'],
            'live_credentials.cancel_url' => ['nullable', 'url', 'max:500'],
        ]);

        $settings = PaymentGatewaySetting::get();

        $testCredentials = $this->mergeCredentials(
            $settings->credentialsFor('test'),
            $validated['test_credentials'] ?? [],
            PaymentGatewaySetting::secretKeys(),
        );

        $liveCredentials = $this->mergeCredentials(
            $settings->credentialsFor('live'),
            $validated['live_credentials'] ?? [],
            PaymentGatewaySetting::secretKeys(),
        );

        $settings->update([
            'donations_enabled' => $request->boolean('donations_enabled'),
            'active_mode' => $validated['active_mode'],
            'test_credentials' => $testCredentials,
            'live_credentials' => $liveCredentials,
        ]);

        return redirect()
            ->route('cp.payment-gateway.edit')
            ->with('success', 'تم حفظ إعدادات بوابة الدفع بنجاح.');
    }

    private function mergeCredentials(array $existing, array $input, array $secretKeys): array
    {
        $merged = $existing;

        foreach (PaymentGatewaySetting::credentialKeys() as $key) {
            if (! array_key_exists($key, $input)) {
                continue;
            }

            $value = trim((string) $input[$key]);

            if (in_array($key, $secretKeys, true) && $value === '') {
                continue;
            }

            $merged[$key] = $value;
        }

        return $merged;
    }
}
