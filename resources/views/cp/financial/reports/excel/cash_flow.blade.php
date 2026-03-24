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
    <div class="title">تقرير التدفق النقدي — جمعية أصدقاء جامعة بيرزيت</div>
    <div class="meta">الفترة: {{ $dateFrom ? $dateFrom . ' — ' . ($dateTo ?? 'الآن') : 'كل الفترات' }}</div>
    <table>
        <thead>
            <tr>
                <th>البند</th>
                <th>القيمة</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>إجمالي التبرعات (الإيرادات)</td>
                <td>{{ number_format((float) ($stats['donations_total'] ?? 0), 2) }} ILS</td>
            </tr>
            <tr>
                <td>إجمالي المصروفات</td>
                <td>{{ number_format((float) ($stats['expenses_total'] ?? 0), 2) }} ILS</td>
            </tr>
            <tr>
                <td><strong>الرصيد</strong></td>
                <td><strong>{{ number_format((float) ($stats['balance'] ?? 0), 2) }} ILS</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
