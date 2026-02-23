@extends('cp.layout')

@section('title', 'التبرعات')

@section('content')
<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h2 class="text-xl font-bold text-slate-800 dark:text-white">التبرعات</h2>
        <a href="{{ route('cp.donations.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-primary hover:bg-primary-dark text-white font-medium text-sm">
            <span class="material-symbols-outlined text-lg">add</span>
            إضافة تبرع
        </a>
    </div>

    <form action="{{ route('cp.donations.index') }}" method="get" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 shadow-sm">
        <div class="flex flex-wrap items-end gap-3">
            <div class="min-w-[140px]">
                <label for="status" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">الحالة</label>
                <select name="status" id="status" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30">
                    <option value="">الكل</option>
                    @foreach(\App\Models\Donation::statuses() as $v => $l)
                        <option value="{{ $v }}" {{ request('status') === $v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[160px]">
                <label for="donation_method" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">طريقة التبرع</label>
                <select name="donation_method" id="donation_method" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30">
                    <option value="">الكل</option>
                    @foreach(\App\Models\Donation::donationMethods() as $v => $l)
                        <option value="{{ $v }}" {{ request('donation_method') === $v ? 'selected' : '' }}>{{ $l }}</option>
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
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="اسم المتبرع أو البريد أو المرجع" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30">
            </div>
            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-200 dark:bg-slate-600 text-slate-700 dark:text-slate-200 text-sm font-medium hover:bg-slate-300 dark:hover:bg-slate-500 transition-colors">تصفية</button>
        </div>
    </form>

    <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        @if($donations->isEmpty())
            <div class="p-12 text-center text-slate-500 dark:text-slate-400">
                <span class="material-symbols-outlined text-4xl mb-2 block">volunteer_activism</span>
                لا توجد تبرعات.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">المتبرع</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">المبلغ</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">الطريقة</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">التاريخ</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">الحالة</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300 w-24">إجراء</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach($donations as $d)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="px-4 py-3">
                                    <span class="font-medium text-slate-800 dark:text-white">{{ $d->donor_name }}</span>
                                    @if($d->donor_type !== 'anonymous')
                                        <span class="block text-xs text-slate-500">{{ $d->donor_type === 'institution' ? 'مؤسسة' : 'فرد' }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-800 dark:text-white">{{ number_format($d->amount, 2) }} {{ $d->currency }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ \App\Models\Donation::donationMethods()[$d->donation_method] ?? $d->donation_method }}</td>
                                <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">{{ $d->donation_date?->format('Y-m-d') ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    @php $statuses = \App\Models\Donation::statuses(); $sc = match($d->status) { 'approved' => 'bg-emerald-500/20 text-emerald-700 dark:text-emerald-400', 'rejected' => 'bg-red-500/20 text-red-600 dark:text-red-400', 'refunded' => 'bg-slate-200 dark:bg-slate-600 text-slate-600 dark:text-slate-300', default => 'bg-amber-500/20 text-amber-600 dark:text-amber-400' }; @endphp
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $sc }}">{{ $statuses[$d->status] ?? $d->status }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('cp.donations.show', $d) }}" class="p-2 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300" title="عرض"><span class="material-symbols-outlined text-lg">visibility</span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($donations->hasPages())
                <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-700">{{ $donations->links() }}</div>
            @endif
        @endif
    </div>
</div>
@endsection
