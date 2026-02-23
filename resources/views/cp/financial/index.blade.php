@extends('cp.layout')

@section('title', 'لوحة المالية')

@section('content')
<div class="space-y-8">
    <section class="rounded-2xl bg-gradient-to-l from-primary/10 to-primary/5 dark:from-primary/20 dark:to-primary/10 border border-primary/20 dark:border-primary/30 p-6 shadow-sm">
        <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-1">لوحة المالية والتبرعات</h2>
        <p class="text-slate-600 dark:text-slate-400">نظرة عامة على التبرعات والحركات المالية والإحصائيات.</p>
    </section>

    @if($stats['donations_pending'] > 0 || $stats['transactions_pending'] > 0)
    <section class="rounded-2xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/50 p-4 flex items-center gap-4">
        <span class="flex items-center justify-center w-12 h-12 rounded-xl bg-amber-500/20 text-amber-600 dark:text-amber-400">
            <span class="material-symbols-outlined text-2xl">pending_actions</span>
        </span>
        <div>
            <p class="font-bold text-slate-800 dark:text-white">
                {{ $stats['donations_pending'] }} تبرع بانتظار المراجعة
                @if($stats['transactions_pending'] > 0)
                    · {{ $stats['transactions_pending'] }} حركة مالية بانتظار الاعتماد
                @endif
            </p>
            <p class="text-sm text-slate-600 dark:text-slate-400">راجع التبرعات والحركات من القائمة الجانبية</p>
        </div>
        <a href="{{ route('cp.donations.index', ['status' => 'pending']) }}" class="ms-auto px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            التبرعات
        </a>
    </section>
    @endif

    {{-- إحصائيات سريعة --}}
    <section>
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">analytics</span>
            إحصائيات مالية
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="{{ route('cp.donations.index') }}" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm hover:shadow-md hover:border-primary/30 transition-all group">
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-xl">volunteer_activism</span>
                    </span>
                    <span class="text-xl font-bold text-slate-800 dark:text-white">{{ number_format($stats['donations_total'], 0) }}</span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">إجمالي التبرعات</p>
            </a>
            <a href="{{ route('cp.financial-transactions.index') }}" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm hover:shadow-md hover:border-primary/30 transition-all group">
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-red-500/20 text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-xl">payments</span>
                    </span>
                    <span class="text-xl font-bold text-slate-800 dark:text-white">{{ number_format($stats['expenses_total'], 0) }}</span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">إجمالي المصروفات</p>
            </a>
            <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-500/20 text-blue-600 dark:text-blue-400">
                        <span class="material-symbols-outlined text-xl">account_balance_wallet</span>
                    </span>
                    <span class="text-xl font-bold text-slate-800 dark:text-white">{{ number_format($stats['balance'], 0) }}</span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">الرصيد التقديري</p>
            </div>
            <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-xl font-bold text-slate-800 dark:text-white">{{ number_format($stats['donations_month'], 0) }}</span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">تبرعات الشهر</p>
            </div>
            <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-xl font-bold text-slate-800 dark:text-white">{{ number_format($stats['donations_year'], 0) }}</span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">تبرعات السنة</p>
            </div>
            <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-xl font-bold {{ $stats['donations_pending'] > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-slate-800 dark:text-white' }}">{{ $stats['donations_pending'] }}</span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">تبرعات معلقة</p>
            </div>
        </div>
    </section>

    {{-- آخر التبرعات والحركات --}}
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h3 class="font-bold text-slate-800 dark:text-white flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">volunteer_activism</span>
                آخر التبرعات
            </h3>
            @if($recentDonations->isEmpty())
                <p class="text-slate-500 dark:text-slate-400 text-sm">لا توجد تبرعات.</p>
            @else
            <ul class="space-y-3">
                @foreach($recentDonations as $d)
                <li>
                    <a href="{{ route('cp.donations.show', $d) }}" class="flex items-start gap-3 group hover:bg-slate-50 dark:hover:bg-slate-700/50 -mx-2 px-2 py-2 rounded-xl transition-colors">
                        @php
                            $s = \App\Models\Donation::statuses();
                            $dClass = match($d->status) { 'approved' => 'bg-emerald-500/20 text-emerald-700 dark:text-emerald-400', 'rejected' => 'bg-red-500/20 text-red-600 dark:text-red-400', default => 'bg-amber-500/20 text-amber-600 dark:text-amber-400' };
                        @endphp
                        <span class="shrink-0 inline-flex px-2 py-0.5 rounded text-xs font-medium {{ $dClass }}">{{ $s[$d->status] ?? $d->status }}</span>
                        <div class="min-w-0">
                            <span class="text-slate-700 dark:text-slate-300 group-hover:text-primary block truncate">{{ $d->donor_name }}</span>
                            <span class="text-xs text-slate-400">{{ number_format($d->amount) }} {{ $d->currency }} · {{ $d->donation_date?->format('Y-m-d') ?? $d->created_at->format('Y-m-d') }}</span>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
            <a href="{{ route('cp.donations.index') }}" class="mt-4 inline-flex items-center gap-1 text-primary font-medium text-sm hover:underline">عرض الكل <span class="material-symbols-outlined text-lg rtl:rotate-180">arrow_back</span></a>
            @endif
        </div>
        <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h3 class="font-bold text-slate-800 dark:text-white flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">payments</span>
                آخر الحركات المالية
            </h3>
            @if($recentTransactions->isEmpty())
                <p class="text-slate-500 dark:text-slate-400 text-sm">لا توجد حركات مالية.</p>
            @else
            <ul class="space-y-3">
                @foreach($recentTransactions as $t)
                <li>
                    <a href="{{ route('cp.financial-transactions.show', $t) }}" class="flex items-start gap-3 group hover:bg-slate-50 dark:hover:bg-slate-700/50 -mx-2 px-2 py-2 rounded-xl transition-colors">
                        @php
                            $st = \App\Models\FinancialTransaction::statuses();
                            $tClass = match($t->status) { 'approved','completed' => 'bg-emerald-500/20 text-emerald-700 dark:text-emerald-400', 'rejected' => 'bg-red-500/20 text-red-600 dark:text-red-400', 'pending_review' => 'bg-amber-500/20 text-amber-600 dark:text-amber-400', default => 'bg-slate-200 dark:bg-slate-600 text-slate-600 dark:text-slate-300' };
                        @endphp
                        <span class="shrink-0 inline-flex px-2 py-0.5 rounded text-xs font-medium {{ $tClass }}">{{ $st[$t->status] ?? $t->status }}</span>
                        <div class="min-w-0">
                            <span class="text-slate-700 dark:text-slate-300 group-hover:text-primary block truncate">{{ $t->beneficiary_name }}</span>
                            <span class="text-xs text-slate-400">{{ number_format($t->amount) }} {{ $t->currency }} · {{ $t->transaction_date?->format('Y-m-d') ?? $t->created_at->format('Y-m-d') }}</span>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
            <a href="{{ route('cp.financial-transactions.index') }}" class="mt-4 inline-flex items-center gap-1 text-primary font-medium text-sm hover:underline">عرض الكل <span class="material-symbols-outlined text-lg rtl:rotate-180">arrow_back</span></a>
            @endif
        </div>
    </section>

    {{-- روابط سريعة --}}
    <section>
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">link</span>
            روابط سريعة
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('cp.donations.create') }}" class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 hover:border-primary/30 hover:shadow-md transition-all flex items-center gap-3 group">
                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">add_circle</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">إضافة تبرع</span>
            </a>
            <a href="{{ route('cp.financial-transactions.create') }}" class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 hover:border-primary/30 hover:shadow-md transition-all flex items-center gap-3 group">
                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">add_circle</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">إضافة حركة مالية</span>
            </a>
            <a href="{{ route('cp.financial.reports.donations') }}" class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 hover:border-primary/30 hover:shadow-md transition-all flex items-center gap-3 group">
                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">assessment</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">تقرير التبرعات</span>
            </a>
            <a href="{{ route('cp.financial.reports.expenses') }}" class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 hover:border-primary/30 hover:shadow-md transition-all flex items-center gap-3 group">
                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">assessment</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">تقرير المصروفات</span>
            </a>
        </div>
    </section>
</div>
@endsection
