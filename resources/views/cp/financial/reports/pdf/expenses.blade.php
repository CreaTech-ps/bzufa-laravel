<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>تقرير المصروفات</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; padding: 20px; }
        h1 { font-size: 18px; margin-bottom: 20px; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: right; }
        th { background: #f0f0f0; font-weight: bold; }
        .total { font-weight: bold; font-size: 14px; margin-top: 15px; }
        .meta { margin-bottom: 15px; color: #666; font-size: 11px; }
    </style>
</head>
<body>
    <h1>تقرير المصروفات والحركات المالية — جمعية أصدقاء جامعة بيرزيت</h1>
    <div class="meta">
        الفترة: {{ $dateFrom ? $dateFrom . ' — ' . ($dateTo ?? 'الآن') : 'كل الفترات' }}<br>
        تاريخ التقرير: {{ now()->format('Y-m-d H:i') }}
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>النوع</th>
                <th>المستفيد</th>
                <th>المبلغ</th>
                <th>التاريخ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $i => $t)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \App\Models\FinancialTransaction::types()[$t->type] ?? $t->type }}</td>
                <td>{{ $t->beneficiary_name }}</td>
                <td>{{ number_format($t->amount, 2) }} {{ $t->currency }}</td>
                <td>{{ $t->transaction_date?->format('Y-m-d') ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="total">الإجمالي: {{ number_format($total, 2) }} ILS</div>
</body>
</html>
