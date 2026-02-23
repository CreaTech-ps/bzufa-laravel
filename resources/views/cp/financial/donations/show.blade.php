@extends('cp.layout')

@section('title', 'عرض تبرع')

@section('content')
<div class="w-full max-w-2xl space-y-6">
    <div class="flex items-center justify-between gap-4">
        <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('cp.donations.index') }}" class="hover:text-primary">التبرعات</a>
            <span class="material-symbols-outlined text-lg">chevron_left</span>
            <span>عرض التبرع</span>
        </div>
        @if($donation->status === 'pending')
        <div class="flex items-center gap-2">
            <form action="{{ route('cp.donations.approve', $donation) }}" method="post" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">check_circle</span>
                    اعتماد
                </button>
            </form>
            <button type="button" id="reject-btn" class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-medium text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">cancel</span>
                رفض
            </button>
            <a href="{{ route('cp.donations.edit', $donation) }}" class="px-4 py-2 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-medium text-sm hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">edit</span>
                تعديل
            </a>
        </div>
        @endif
    </div>

    <div id="reject-form" class="hidden rounded-2xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4">
        <form action="{{ route('cp.donations.reject', $donation) }}" method="post">
            @csrf
            <label for="rejection_reason" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">سبب الرفض (اختياري)</label>
            <textarea name="rejection_reason" id="rejection_reason" rows="2" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2 mb-2"></textarea>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-medium text-sm">تأكيد الرفض</button>
                <button type="button" id="cancel-reject" class="px-4 py-2 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-medium text-sm">إلغاء</button>
            </div>
        </form>
    </div>

    <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white">{{ $donation->donor_name }}</h2>
            @php $statuses = \App\Models\Donation::statuses(); $sc = match($donation->status) { 'approved' => 'bg-emerald-500/20 text-emerald-700 dark:text-emerald-400', 'rejected' => 'bg-red-500/20 text-red-600 dark:text-red-400', 'refunded' => 'bg-slate-200 dark:bg-slate-600 text-slate-600 dark:text-slate-300', default => 'bg-amber-500/20 text-amber-600 dark:text-amber-400' }; @endphp
            <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $sc }}">{{ $statuses[$donation->status] ?? $donation->status }}</span>
        </div>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
            <div><dt class="text-slate-500 dark:text-slate-400">نوع المتبرع</dt><dd class="font-medium text-slate-800 dark:text-white">{{ \App\Models\Donation::donorTypes()[$donation->donor_type] ?? $donation->donor_type }}</dd></div>
            @if($donation->donor_email)<div><dt class="text-slate-500 dark:text-slate-400">البريد</dt><dd class="font-medium text-slate-800 dark:text-white">{{ $donation->donor_email }}</dd></div>@endif
            @if($donation->donor_phone)<div><dt class="text-slate-500 dark:text-slate-400">الهاتف</dt><dd class="font-medium text-slate-800 dark:text-white">{{ $donation->donor_phone }}</dd></div>@endif
            <div><dt class="text-slate-500 dark:text-slate-400">المبلغ</dt><dd class="font-bold text-lg text-primary">{{ number_format($donation->amount, 2) }} {{ $donation->currency }}</dd></div>
            <div><dt class="text-slate-500 dark:text-slate-400">التاريخ</dt><dd class="font-medium text-slate-800 dark:text-white">{{ $donation->donation_date?->format('Y-m-d') ?? '—' }}</dd></div>
            <div><dt class="text-slate-500 dark:text-slate-400">طريقة التبرع</dt><dd class="font-medium text-slate-800 dark:text-white">{{ \App\Models\Donation::donationMethods()[$donation->donation_method] ?? $donation->donation_method }}</dd></div>
            @if($donation->reference_number)<div><dt class="text-slate-500 dark:text-slate-400">الرقم المرجعي</dt><dd class="font-medium text-slate-800 dark:text-white">{{ $donation->reference_number }}</dd></div>@endif
            @if($donation->purpose)<div><dt class="text-slate-500 dark:text-slate-400">الغرض</dt><dd class="font-medium text-slate-800 dark:text-white">{{ \App\Models\Donation::purposes()[$donation->purpose] ?? $donation->purpose }}</dd></div>@endif
            @if($donation->notes)<div class="sm:col-span-2"><dt class="text-slate-500 dark:text-slate-400">ملاحظات</dt><dd class="font-medium text-slate-800 dark:text-white">{{ $donation->notes }}</dd></div>@endif
            @if($donation->reviewed_at)<div><dt class="text-slate-500 dark:text-slate-400">تاريخ المراجعة</dt><dd class="font-medium text-slate-800 dark:text-white">{{ $donation->reviewed_at->format('Y-m-d H:i') }}</dd></div>@endif
            @if($donation->reviewer)<div><dt class="text-slate-500 dark:text-slate-400">المُراجِع</dt><dd class="font-medium text-slate-800 dark:text-white">{{ $donation->reviewer->name ?? $donation->reviewer->email ?? '—' }}</dd></div>@endif
            @if($donation->rejection_reason)<div class="sm:col-span-2"><dt class="text-slate-500 dark:text-slate-400">سبب الرفض</dt><dd class="font-medium text-red-600 dark:text-red-400">{{ $donation->rejection_reason }}</dd></div>@endif
        </dl>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('reject-btn')?.addEventListener('click', function() {
    document.getElementById('reject-form').classList.remove('hidden');
});
document.getElementById('cancel-reject')?.addEventListener('click', function() {
    document.getElementById('reject-form').classList.add('hidden');
});
</script>
@endpush
@endsection
