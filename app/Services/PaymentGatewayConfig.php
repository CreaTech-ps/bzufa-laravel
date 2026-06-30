<?php

namespace App\Services;

use App\Models\PaymentGatewaySetting;

class PaymentGatewayConfig
{
    public function settings(): PaymentGatewaySetting
    {
        return PaymentGatewaySetting::get();
    }

    public function donationsEnabled(): bool
    {
        return (bool) $this->settings()->donations_enabled;
    }

    public function activeMode(): string
    {
        $mode = $this->settings()->active_mode;

        return in_array($mode, ['test', 'live'], true) ? $mode : 'test';
    }

    public function isTestMode(): bool
    {
        return $this->activeMode() === 'test';
    }

    public function isLiveMode(): bool
    {
        return $this->activeMode() === 'live';
    }

    public function lahza(): array
    {
        return $this->lahzaForMode($this->activeMode());
    }

    public function lahzaForMode(string $mode): array
    {
        $stored = $this->settings()->credentialsFor($mode);
        $env = config('services.lahza', []);

        $resolved = [];
        foreach (PaymentGatewaySetting::credentialKeys() as $key) {
            $resolved[$key] = $this->resolveValue($stored[$key] ?? '', $env[$key] ?? '');
        }

        if ($resolved['checkout_url'] === '') {
            $resolved['checkout_url'] = 'https://pay.lahza.io';
        }
        if ($resolved['api_base_url'] === '') {
            $resolved['api_base_url'] = 'https://api.lahza.io';
        }

        return $resolved;
    }

    public function webhookSecret(): string
    {
        return (string) ($this->lahza()['webhook_secret'] ?? '');
    }

    public function isConfigured(): bool
    {
        $lahza = $this->lahza();

        return trim((string) ($lahza['secret_key'] ?? '')) !== ''
            && (
                trim((string) ($lahza['payment_page_url'] ?? '')) !== ''
                || trim((string) ($lahza['page_id'] ?? '')) !== ''
            );
    }

    private function resolveValue(mixed $stored, mixed $env): string
    {
        $storedValue = trim((string) $stored);
        if ($storedValue !== '') {
            return $storedValue;
        }

        return trim((string) $env);
    }
}
