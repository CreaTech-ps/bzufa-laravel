<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>تقرير التدفق النقدي</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; padding: 20px; }
        h1 { font-size: 18px; margin-bottom: 20px; text-align: center; }
        .box { border: 1px solid #333; padding: 15px; margin: 10px 0; }
        .box.donations { background: #e8f5e9; }
        .box.expenses { background: #ffebee; }
        .box.balance { background: #e3f2fd; }
        .total { font-weight: bold; font-size: 16px; }
        .meta { margin-bottom: 15px; color: #666; font-size: 11px; }
    </style>
</head>
<body>
    <h1>تقرير التدفق النقدي — جمعية أصدقاء جامعة بيرزيت</h1>
    <div class="meta">
        الفترة: {{ $stats['date_from'] ? $stats['date_from'] . ' — ' . ($stats['date_to'] ?? 'الآن') : 'كل الفترات' }}<br>
        تاريخ التقرير: {{ now()->format('Y-m-d H:i') }}
    </div>
    <div class="box donations">
        <strong>إجمالي التبرعات (الإيرادات):</strong> {{ number_format($stats['donations_total'] ?? 0, 2) }} ILS
    </div>
    <div class="box expenses">
        <strong>إجمالي المصروفات:</strong> {{ number_format($stats['expenses_total'] ?? 0, 2) }} ILS
    </div>
    <div class="box balance">
        <strong>الرصيد:</strong> {{ number_format($stats['balance'] ?? 0, 2) }} ILS
    </div>
</body>
</html>
