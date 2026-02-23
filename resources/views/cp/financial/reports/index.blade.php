@extends('cp.layout')

@section('title', 'التقارير والإحصائيات')

@section('content')
<div class="space-y-6">
    <h2 class="text-xl font-bold text-slate-800 dark:text-white">التقارير والإحصائيات المالية</h2>

    <form action="{{ route('cp.financial.reports.index') }}" method="get" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 shadow-sm">
        <div class="flex flex-wrap items-end gap-3">
            <div class="min-w-[130px]">
                <label for="date_from" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">من تاريخ</label>
                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm">
            </div>
            <div class="min-w-[130px]">
                <label for="date_to" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">إلى تاريخ</label>
                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm">
            </div>
            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-200 dark:bg-slate-600 text-slate-700 dark:text-slate-200 text-sm font-medium">عرض</button>
        </div>
    </form>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm">
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-1">إجمالي التبرعات</p>
            <p class="text-xl font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($stats['donations_total'] ?? 0, 0) }}</p>
        </div>
        <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm">
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-1">عدد التبرعات</p>
            <p class="text-xl font-bold text-slate-800 dark:text-white">{{ $stats['donations_count'] ?? 0 }}</p>
        </div>
        <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm">
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-1">إجمالي المصروفات</p>
            <p class="text-xl font-bold text-red-600 dark:text-red-400">{{ number_format($stats['expenses_total'] ?? 0, 0) }}</p>
        </div>
        <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm">
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-1">عدد الحركات</p>
            <p class="text-xl font-bold text-slate-800 dark:text-white">{{ $stats['expenses_count'] ?? 0 }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('cp.financial.reports.donations', request()->query()) }}" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm hover:border-primary/30 hover:shadow-md transition-all flex items-center gap-4 group">
            <span class="flex items-center justify-center w-14 h-14 rounded-xl bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-2xl">volunteer_activism</span>
            </span>
            <div>
                <h3 class="font-bold text-slate-800 dark:text-white">تقرير التبرعات</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">عرض وتصدير قائمة التبرعات حسب الفترة</p>
            </div>
            <span class="material-symbols-outlined text-slate-400 group-hover:text-primary ms-auto">arrow_back</span>
        </a>
        <a href="{{ route('cp.financial.reports.expenses', request()->query()) }}" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm hover:border-primary/30 hover:shadow-md transition-all flex items-center gap-4 group">
            <span class="flex items-center justify-center w-14 h-14 rounded-xl bg-red-500/20 text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-2xl">payments</span>
            </span>
            <div>
                <h3 class="font-bold text-slate-800 dark:text-white">تقرير المصروفات</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">عرض وتصدير قائمة المصروفات والحركات</p>
            </div>
            <span class="material-symbols-outlined text-slate-400 group-hover:text-primary ms-auto">arrow_back</span>
        </a>
        <a href="{{ route('cp.financial.reports.cash-flow', request()->query()) }}" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm hover:border-primary/30 hover:shadow-md transition-all flex items-center gap-4 group">
            <span class="flex items-center justify-center w-14 h-14 rounded-xl bg-blue-500/20 text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-2xl">account_balance_wallet</span>
            </span>
            <div>
                <h3 class="font-bold text-slate-800 dark:text-white">تقرير التدفق النقدي</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">ملخص الإيرادات والمصروفات والرصيد</p>
            </div>
            <span class="material-symbols-outlined text-slate-400 group-hover:text-primary ms-auto">arrow_back</span>
        </a>
    </div>
</div>
@endsection
