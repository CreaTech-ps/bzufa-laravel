<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('donate.email_subject_receipt') }}</title>
</head>
<body style="margin:0;padding:24px;font-family:Tahoma,Arial,sans-serif;background:#f4f4f5;color:#1e293b;">
    <div style="max-width:560px;margin:0 auto;background:#fff;border-radius:12px;padding:24px;border:1px solid #e2e8f0;">
        <h1 style="margin:0 0 16px;font-size:20px;color:#0f172a;">{{ __('donate.email_heading') }}</h1>
        <p style="margin:0 0 20px;font-size:14px;line-height:1.6;color:#475569;">{{ __('donate.email_intro') }}</p>

        <table style="width:100%;border-collapse:collapse;font-size:14px;">
            <tr>
                <td style="padding:8px 0;color:#64748b;width:40%;">{{ __('donate.email_store_name') }}</td>
                <td style="padding:8px 0;font-weight:600;">{{ $storeName }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:#64748b;">{{ __('donate.email_transaction_date') }}</td>
                <td style="padding:8px 0;font-weight:600;">{{ $donation->reviewed_at?->timezone(config('app.timezone'))->format('Y-m-d H:i') ?? $donation->donation_date?->format('Y-m-d') ?? '—' }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:#64748b;">{{ __('donate.email_order_reference') }}</td>
                <td style="padding:8px 0;font-weight:600;direction:ltr;text-align:{{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ $donation->reference_number }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:#64748b;">{{ __('donate.email_transaction_id') }}</td>
                <td style="padding:8px 0;font-weight:600;direction:ltr;text-align:{{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">{{ $donation->gateway_transaction_id ?? '—' }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:#64748b;">{{ __('donate.email_card_type') }}</td>
                <td style="padding:8px 0;font-weight:600;">{{ $cardBrand ?? __('donate.email_card_unknown') }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:#64748b;vertical-align:top;">{{ __('donate.email_order_details') }}</td>
                <td style="padding:8px 0;">
                    @if($donation->purpose)
                        <div><strong>{{ __('donate.field_purpose') }}:</strong> {{ \App\Models\Donation::purposes()[$donation->purpose] ?? $donation->purpose }}</div>
                    @endif
                    @if($donation->notes)
                        <div style="margin-top:6px;"><strong>{{ __('donate.field_notes') }}:</strong> {{ $donation->notes }}</div>
                    @endif
                    @if(!$donation->purpose && !$donation->notes)
                        {{ __('donate.email_no_extra_details') }}
                    @endif
                </td>
            </tr>
            <tr>
                <td style="padding:12px 0 8px;color:#64748b;border-top:1px solid #e2e8f0;">{{ __('donate.email_amount') }}</td>
                <td style="padding:12px 0 8px;border-top:1px solid #e2e8f0;font-size:18px;font-weight:800;color:#08A46D;">{{ number_format((float) $donation->amount, 2) }} {{ $donation->currency }}</td>
            </tr>
        </table>

        <p style="margin:24px 0 0;font-size:12px;color:#94a3b8;line-height:1.5;">{{ __('donate.email_footer_note') }}</p>
    </div>
</body>
</html>
