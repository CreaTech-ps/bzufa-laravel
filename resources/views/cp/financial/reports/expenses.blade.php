@extends('cp.layout')

@section('title', 'تقرير المصروفات')

@section('content')
<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h2 class="text-xl font-bold text-slate-800 dark:text-white">تقرير المصروفات</h2>
        <a href="{{ route('cp.financial.reports.expenses', array_merge(request()->query(), ['export' => 'pdf'])) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-medium text-sm">
            <span class="material-symbols-outlined text-lg">picture_as_pdf</span>
            تصدير PDF
        </a>
    </div>

    <form action="{{ route('cp.financial.reports.expenses') }}" method="get" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 shadow-sm">
        <div class="flex flex-wrap items-end gap-3">
            <div class="min-w-[130px]">
                <label for="date_from" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">من تاريخ</label>
                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm">
            </div>
            <div class="min-w-[130px]">
                <label for="date_to" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">إلى تاريخ</label>
                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm">
            </div>
            <div class="min-w-[140px]">
                <label for="type" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">النوع</label>
                <select name="type" id="type" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm">
                    <option value="">الكل</option>
                    @foreach(\App\Models\FinancialTransaction::types() as $v => $l)
                        <option value="{{ $v }}" {{ request('type') === $v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-200 dark:bg-slate-600 text-slate-700 dark:text-slate-200 text-sm font-medium">تصفية</button>
        </div>
    </form>

    <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        @if($transactions->isEmpty())
            <div class="p-12 text-center text-slate-500 dark:text-slate-400">لا توجد حركات مالية في الفترة المحددة.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">#</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">النوع</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">المستفيد</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">المبلغ</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">التاريخ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach($transactions as $i => $t)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                <td class="px-4 py-3 text-sm text-slate-500">{{ $transactions instanceof \Illuminate\Pagination\LengthAwarePaginator ? ($transactions->firstItem() + $i) : ($i + 1) }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ \App\Models\FinancialTransaction::types()[$t->type] ?? $t->type }}</td>
                                <td class="px-4 py-3 font-medium text-slate-800 dark:text-white">{{ $t->beneficiary_name }}</td>
                                <td class="px-4 py-3 font-medium text-slate-800 dark:text-white">{{ number_format($t->amount, 2) }} {{ $t->currency }}</td>
                                <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">{{ $t->transaction_date?->format('Y-m-d') ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-700 flex justify-between items-center">
                <span class="font-bold text-slate-800 dark:text-white">الإجمالي: {{ number_format($total, 2) }} ILS</span>
                @if(method_exists($transactions, 'links'))
                    {{ $transactions->links() }}
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
