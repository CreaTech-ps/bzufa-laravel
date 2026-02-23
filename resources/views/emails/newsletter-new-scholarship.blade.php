@php
    $locale = $subscriberLocale ?? 'ar';
    $title = ($locale === 'en' && $scholarship->title_en) ? $scholarship->title_en : $scholarship->title_ar;
    $summary = ($locale === 'en' && $scholarship->summary_en) ? $scholarship->summary_en : $scholarship->summary_ar;
    $slug = ($locale === 'en' && $scholarship->slug_en) ? $scholarship->slug_en : $scholarship->slug_ar;
    $grantUrl = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($locale, route('grants.show', ['slug' => $slug], false), [], true);
    $isRtl = $locale === 'ar';
@endphp
<!DOCTYPE html>
<html dir="{{ $isRtl ? 'rtl' : 'ltr' }}" lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $locale === 'ar' ? 'منحة جديدة' : 'New scholarship' }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Tajawal, Arial, sans-serif; background-color: #f1f5f9; line-height: 1.7;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f1f5f9;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background: linear-gradient(135deg, #0BA66D 0%, #089658 100%); padding: 32px 40px; text-align: center;">
                            <p style="margin: 0 0 8px 0; font-size: 12px; font-weight: 700; color: rgba(255,255,255,0.9); text-transform: uppercase;">{{ $locale === 'ar' ? 'نشرة الجمعية' : 'Association Newsletter' }}</p>
                            <h1 style="margin: 0; font-size: 24px; font-weight: 800; color: #ffffff;">{{ $locale === 'ar' ? 'منحة جديدة متاحة' : 'New scholarship available' }}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="margin: 0 0 16px 0; font-size: 20px; color: #1e293b;">{{ $title }}</h2>
                            @if($summary)
                            <p style="margin: 0 0 24px 0; font-size: 15px; color: #475569;">{{ Str::limit(strip_tags($summary), 200) }}</p>
                            @endif
                            <a href="{{ $grantUrl }}" style="display: inline-block; padding: 12px 24px; background: #0BA66D; color: #ffffff !important; text-decoration: none; font-weight: 600; border-radius: 12px;">{{ $locale === 'ar' ? 'التقديم على المنحة' : 'Apply for this scholarship' }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 24px 40px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; text-align: center;">
                            <p style="margin: 0; font-size: 13px; color: #64748b;">{{ $locale === 'ar' ? 'جمعية أصدقاء جامعة بيرزيت' : 'Friends of Birzeit University Association' }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
