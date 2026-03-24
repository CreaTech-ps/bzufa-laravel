<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إيصال تبرع - {{ $donation->reference_number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #0f172a;
            margin: 24px;
            line-height: 1.7;
        }
        .header {
            border-bottom: 2px solid #08A46D;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }
        .title {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 4px;
        }
        .subtitle {
            color: #475569;
            margin: 0;
            font-size: 12px;
        }
        .box {
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 14px;
            margin-top: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        td {
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }
        td.label {
            color: #334155;
            width: 35%;
            font-weight: 700;
        }
        .amount {
            color: #08A46D;
            font-weight: 700;
            font-size: 18px;
        }
        .footer {
            margin-top: 18px;
            color: #64748b;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">إيصال تبرع إلكتروني</h1>
        <p class="subtitle">جمعية أصدقاء جامعة بيرزيت</p>
    </div>

    <div class="box">
        <table>
            <tr>
                <td class="label">رقم المرجع</td>
                <td>{{ $donation->reference_number }}</td>
            </tr>
            <tr>
                <td class="label">اسم المتبرع</td>
                <td>{{ $donation->donor_name ?: 'متبرع إلكتروني' }}</td>
            </tr>
            <tr>
                <td class="label">البريد الإلكتروني</td>
                <td>{{ $donation->donor_email ?: '—' }}</td>
            </tr>
            <tr>
                <td class="label">رقم الجوال</td>
                <td>{{ $donation->donor_phone ?: '—' }}</td>
            </tr>
            <tr>
                <td class="label">المبلغ</td>
                <td class="amount">{{ number_format($donation->amount, 2) }} {{ $donation->currency }}</td>
            </tr>
            <tr>
                <td class="label">تاريخ التبرع</td>
                <td>{{ $donation->donation_date?->format('Y-m-d') ?? $donation->created_at?->format('Y-m-d') }}</td>
            </tr>
            <tr>
                <td class="label">رقم العملية الإلكترونية</td>
                <td>{{ $donation->gateway_transaction_id ?: '—' }}</td>
            </tr>
            <tr>
                <td class="label">الحالة</td>
                <td>{{ \App\Models\Donation::statuses()[$donation->status] ?? $donation->status }}</td>
            </tr>
        </table>
    </div>

    <p class="footer">
        تم إصدار هذا الإيصال تلقائيًا بواسطة النظام بتاريخ {{ now()->format('Y-m-d H:i') }}.
    </p>
</body>
</html>
