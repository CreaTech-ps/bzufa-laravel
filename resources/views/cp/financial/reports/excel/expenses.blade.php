<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #9ca3af; padding: 8px; text-align: right; }
        th { background: #e5e7eb; font-weight: bold; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 10px; }
        .meta { color: #374151; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="title">تقرير المصروفات — جمعية أصدقاء جامعة بيرزيت</div>
    <div class="meta">الفترة: {{ $dateFrom ? $dateFrom . ' — ' . ($dateTo ?? 'الآن') : 'كل الفترات' }}</div>
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
            <tr>
                <td colspan="2"><strong>الإجمالي</strong></td>
                <td colspan="3"><strong>{{ number_format($total, 2) }} ILS</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
