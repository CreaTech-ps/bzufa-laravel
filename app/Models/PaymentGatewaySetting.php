<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGatewaySetting extends Model
{
    protected $fillable = [
        'donations_enabled',
        'active_mode',
        'test_credentials',
        'live_credentials',
    ];

    protected function casts(): array
    {
        return [
            'donations_enabled' => 'boolean',
            'test_credentials' => 'encrypted:array',
            'live_credentials' => 'encrypted:array',
        ];
    }

    public static function credentialKeys(): array
    {
        return [
            'public_key',
            'secret_key',
            'page_id',
            'payment_page_url',
            'webhook_secret',
            'checkout_url',
            'api_base_url',
            'success_url',
            'cancel_url',
        ];
    }

    public static function secretKeys(): array
    {
        return ['secret_key', 'webhook_secret'];
    }

    public static function defaultCredentials(): array
    {
        return array_fill_keys(static::credentialKeys(), '');
    }

    public static function get(): self
    {
        $row = static::first();
        if ($row) {
            return $row;
        }

        return static::create([
            'donations_enabled' => true,
            'active_mode' => 'test',
            'test_credentials' => static::defaultCredentials(),
            'live_credentials' => static::defaultCredentials(),
        ]);
    }

    public function credentialsFor(string $mode): array
    {
        $stored = $mode === 'live'
            ? ($this->live_credentials ?? [])
            : ($this->test_credentials ?? []);

        return array_merge(static::defaultCredentials(), is_array($stored) ? $stored : []);
    }

    public function hasStoredSecret(string $mode, string $key): bool
    {
        if (! in_array($key, static::secretKeys(), true)) {
            return false;
        }

        $value = trim((string) ($this->credentialsFor($mode)[$key] ?? ''));

        return $value !== '';
    }
}
