@php
    $locale = $subscriberLocale ?? 'ar';
    $title = $locale === 'en' && $news->title_en ? $news->title_en : $news->title_ar;
    $summary = $locale === 'en' && $news->summary_en ? $news->summary_en : $news->summary_ar;
    $slug = $locale === 'en' && $news->slug_en ? $news->slug_en : $news->slug_ar;
    $newsUrl = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($locale, route('news.show', ['slug' => $slug], false), [], true);
    $isRtl = $locale === 'ar';
@endphp
<!DOCTYPE html>
<html dir="{{ $isRtl ? 'rtl' : 'ltr' }}" lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f1f5f9; line-height: 1.7;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f1f5f9;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background: #0BA66D; padding: 32px; text-align: center;">
                            <h1 style="margin: 0; font-size: 24px; font-weight: 800; color: #ffffff;">{{ $locale === 'ar' ? 'خبر جديد' : 'New article' }}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="margin: 0 0 16px 0; font-size: 20px; color: #1e293b;">{{ $title }}</h2>
                            @if($summary)
                            <p style="margin: 0 0 24px 0; font-size: 15px; color: #475569;">{{ Str::limit(strip_tags($summary), 200) }}</p>
                            @endif
                            <a href="{{ $newsUrl }}" style="display: inline-block; padding: 12px 24px; background: #0BA66D; color: #ffffff !important; text-decoration: none; font-weight: 600; border-radius: 12px;">{{ $locale === 'ar' ? 'اقرأ الخبر' : 'Read more' }}</a>
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
