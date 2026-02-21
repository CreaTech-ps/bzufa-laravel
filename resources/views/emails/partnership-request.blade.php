<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب شراكة جديد — جمعية أصدقاء جامعة بيرزيت</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
</head>
<body style="margin: 0; padding: 0; font-family: 'Tajawal', Arial, sans-serif; background-color: #f1f5f9; line-height: 1.7;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f1f5f9;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);">
                    {{-- Header --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #0BA66D 0%, #089658 100%); padding: 32px 40px; text-align: center;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td>
                                        <p style="margin: 0 0 8px 0; font-size: 12px; font-weight: 700; color: rgba(255,255,255,0.9); text-transform: uppercase; letter-spacing: 2px;">إشعار جديد</p>
                                        <h1 style="margin: 0; font-size: 28px; font-weight: 800; color: #ffffff;">طلب شراكة جديد</h1>
                                        <p style="margin: 12px 0 0 0; font-size: 15px; color: rgba(255,255,255,0.95);">جمعية أصدقاء جامعة بيرزيت — شركاء النجاح</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    {{-- Body --}}
                    <tr>
                        <td style="padding: 40px;">
                            <p style="margin: 0 0 24px 0; font-size: 16px; color: #475569;">تم استلام طلب شراكة جديد من الموقع. فيما يلي تفاصيل الطلب:</p>

                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
                                <tr style="background-color: #f8fafc;">
                                    <td style="padding: 16px 20px; font-weight: 700; color: #64748b; width: 180px; font-size: 14px; border-bottom: 1px solid #e2e8f0;">اسم الشركة/المؤسسة</td>
                                    <td style="padding: 16px 20px; color: #1e293b; font-size: 15px; border-bottom: 1px solid #e2e8f0;">{{ $request->company_name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 16px 20px; font-weight: 700; color: #64748b; font-size: 14px; border-bottom: 1px solid #e2e8f0;">اسم المسؤول</td>
                                    <td style="padding: 16px 20px; color: #1e293b; font-size: 15px; border-bottom: 1px solid #e2e8f0;">{{ $request->contact_name }}</td>
                                </tr>
                                <tr style="background-color: #f8fafc;">
                                    <td style="padding: 16px 20px; font-weight: 700; color: #64748b; font-size: 14px; border-bottom: 1px solid #e2e8f0;">البريد الإلكتروني</td>
                                    <td style="padding: 16px 20px; color: #1e293b; font-size: 15px; border-bottom: 1px solid #e2e8f0;">
                                        <a href="mailto:{{ $request->email }}" style="color: #0BA66D; text-decoration: none; font-weight: 500;">{{ $request->email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 16px 20px; font-weight: 700; color: #64748b; font-size: 14px; border-bottom: 1px solid #e2e8f0;">رقم التواصل</td>
                                    <td style="padding: 16px 20px; color: #1e293b; font-size: 15px; border-bottom: 1px solid #e2e8f0;">
                                        <a href="tel:{{ $request->phone }}" style="color: #0BA66D; text-decoration: none; font-weight: 500;">{{ $request->phone }}</a>
                                    </td>
                                </tr>
                                @if(!empty($request->message))
                                <tr style="background-color: #f8fafc;">
                                    <td style="padding: 16px 20px; font-weight: 700; color: #64748b; font-size: 14px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">الرسالة</td>
                                    <td style="padding: 16px 20px; color: #1e293b; font-size: 15px; border-bottom: 1px solid #e2e8f0;">{{ $request->message }}</td>
                                </tr>
                                @endif
                                <tr style="background-color: #f8fafc;">
                                    <td style="padding: 16px 20px; font-weight: 700; color: #64748b; font-size: 14px;">تاريخ وتوقيت التقديم</td>
                                    <td style="padding: 16px 20px; color: #1e293b; font-size: 15px;">{{ $request->created_at->locale('ar')->translatedFormat('l، d F Y - h:i a') }}</td>
                                </tr>
                            </table>

                            <div style="margin-top: 24px; padding: 20px; background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border-right: 4px solid #0BA66D; border-radius: 12px;">
                                <p style="margin: 0; font-size: 15px; color: #166534; font-weight: 500;">
                                    <strong>💼 ملاحظة:</strong> يرجى التواصل مع طالب الشراكة في أقرب وقت لمعالجة طلبه.
                                </p>
                            </div>
                        </td>
                    </tr>
                    {{-- Footer --}}
                    <tr>
                        <td style="padding: 24px 40px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; text-align: center;">
                            <p style="margin: 0; font-size: 13px; color: #64748b;">هذا إيميل تلقائي من نظام جمعية أصدقاء جامعة بيرزيت</p>
                            <p style="margin: 8px 0 0 0; font-size: 12px; color: #94a3b8;">© {{ date('Y') }} جمعية أصدقاء جامعة بيرزيت — Friends of Birzeit University Association</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
