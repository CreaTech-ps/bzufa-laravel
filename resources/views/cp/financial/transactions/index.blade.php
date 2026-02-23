@extends('cp.layout')

@section('title', 'الحركات المالية')

@section('content')
<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h2 class="text-xl font-bold text-slate-800 dark:text-white">الحركات المالية</h2>
        <a href="{{ route('cp.financial-transactions.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-primary hover:bg-primary-dark text-white font-medium text-sm">
            <span class="material-symbols-outlined text-lg">add</span>
            إضافة حركة مالية
        </a>
    </div>

    <form action="{{ route('cp.financial-transactions.index') }}" method="get" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 shadow-sm">
        <div class="flex flex-wrap items-end gap-3">
            <div class="min-w-[140px]">
                <label for="status" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">الحالة</label>
                <select name="status" id="status" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30">
                    <option value="">الكل</option>
                    @foreach(\App\Models\FinancialTransaction::statuses() as $v => $l)
                        <option value="{{ $v }}" {{ request('status') === $v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[140px]">
                <label for="type" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">النوع</label>
                <select name="type" id="type" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30">
                    <option value="">الكل</option>
                    @foreach(\App\Models\FinancialTransaction::types() as $v => $l)
                        <option value="{{ $v }}" {{ request('type') === $v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[130px]">
                <label for="date_from" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">من تاريخ</label>
                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30">
            </div>
            <div class="min-w-[130px]">
                <label for="date_to" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">إلى تاريخ</label>
                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30">
            </div>
            <div class="min-w-[180px]">
                <label for="search" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">بحث</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="المستفيد أو المرجع أو الغرض" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30">
            </div>
            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-200 dark:bg-slate-600 text-slate-700 dark:text-slate-200 text-sm font-medium hover:bg-slate-300 dark:hover:bg-slate-500 transition-colors">تصفية</button>
        </div>
    </form>

    <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        @if($transactions->isEmpty())
            <div class="p-12 text-center text-slate-500 dark:text-slate-400">
                <span class="material-symbols-outlined text-4xl mb-2 block">payments</span>
                لا توجد حركات مالية.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">النوع</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">المستفيد</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">المبلغ</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">التاريخ</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">الحالة</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300 w-24">إجراء</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach($transactions as $t)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ \App\Models\FinancialTransaction::types()[$t->type] ?? $t->type }}</td>
                                <td class="px-4 py-3">
                                    <span class="font-medium text-slate-800 dark:text-white">{{ $t->beneficiary_name }}</span>
                                    <span class="block text-xs text-slate-500">{{ Str::limit($t->purpose, 40) }}</span>
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-800 dark:text-white">{{ number_format($t->amount, 2) }} {{ $t->currency }}</td>
                                <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">{{ $t->transaction_date?->format('Y-m-d') ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    @php $st = \App\Models\FinancialTransaction::statuses(); $sc = match($t->status) { 'approved','completed' => 'bg-emerald-500/20 text-emerald-700 dark:text-emerald-400', 'rejected' => 'bg-red-500/20 text-red-600 dark:text-red-400', 'pending_review' => 'bg-amber-500/20 text-amber-600 dark:text-amber-400', default => 'bg-slate-200 dark:bg-slate-600 text-slate-600 dark:text-slate-300' }; @endphp
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $sc }}">{{ $st[$t->status] ?? $t->status }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('cp.financial-transactions.show', $t) }}" class="p-2 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300" title="عرض"><span class="material-symbols-outlined text-lg">visibility</span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($transactions->hasPages())
                <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-700">{{ $transactions->links() }}</div>
            @endif
        @endif
    </div>
</div>
@endsection
