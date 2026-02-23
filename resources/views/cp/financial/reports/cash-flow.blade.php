@extends('cp.layout')

@section('title', 'تقرير التدفق النقدي')

@section('content')
<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h2 class="text-xl font-bold text-slate-800 dark:text-white">تقرير التدفق النقدي</h2>
        <a href="{{ route('cp.financial.reports.cash-flow', array_merge(request()->query(), ['export' => 'pdf'])) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-medium text-sm">
            <span class="material-symbols-outlined text-lg">picture_as_pdf</span>
            تصدير PDF
        </a>
    </div>

    <form action="{{ route('cp.financial.reports.cash-flow') }}" method="get" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 shadow-sm">
        <div class="flex flex-wrap items-end gap-3">
            <div class="min-w-[130px]">
                <label for="date_from" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">من تاريخ</label>
                <input type="date" name="date_from" id="date_from" value="{{ request('date_from', $stats['date_from'] ?? '') }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm">
            </div>
            <div class="min-w-[130px]">
                <label for="date_to" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">إلى تاريخ</label>
                <input type="date" name="date_to" id="date_to" value="{{ request('date_to', $stats['date_to'] ?? '') }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm">
            </div>
            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-200 dark:bg-slate-600 text-slate-700 dark:text-slate-200 text-sm font-medium">عرض</button>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 p-6">
            <p class="text-sm text-emerald-700 dark:text-emerald-400 mb-1">إجمالي التبرعات (الإيرادات)</p>
            <p class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">{{ number_format($stats['donations_total'] ?? 0, 2) }} ILS</p>
        </div>
        <div class="rounded-2xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-6">
            <p class="text-sm text-red-700 dark:text-red-400 mb-1">إجمالي المصروفات</p>
            <p class="text-2xl font-bold text-red-700 dark:text-red-300">{{ number_format($stats['expenses_total'] ?? 0, 2) }} ILS</p>
        </div>
        <div class="rounded-2xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 p-6">
            <p class="text-sm text-blue-700 dark:text-blue-400 mb-1">الرصيد</p>
            <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ number_format($stats['balance'] ?? 0, 2) }} ILS</p>
        </div>
    </div>

    <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
        <h3 class="font-bold text-slate-800 dark:text-white mb-2">ملخص</h3>
        <p class="text-slate-600 dark:text-slate-400 text-sm">
            الفترة: {{ $stats['date_from'] ? $stats['date_from'] . ' — ' . ($stats['date_to'] ?? 'الآن') : 'كل الفترات' }}
        </p>
        <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">
            الرصيد = إجمالي التبرعات − إجمالي المصروفات
        </p>
    </div>
</div>
@endsection
