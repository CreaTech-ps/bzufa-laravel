@extends('cp.layout')

@section('title', 'عرض حركة مالية')

@section('content')
<div class="w-full max-w-2xl space-y-6">
    <div class="flex items-center justify-between gap-4">
        <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('cp.financial-transactions.index') }}" class="hover:text-primary">الحركات المالية</a>
            <span class="material-symbols-outlined text-lg">chevron_left</span>
            <span>عرض الحركة</span>
        </div>
        @if(in_array($financialTransaction->status, ['draft', 'pending_review', 'approved']))
        <div class="flex items-center gap-2">
            @if($financialTransaction->status === 'draft')
                <form action="{{ route('cp.financial-transactions.submit', $financialTransaction) }}" method="post" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm">إرسال للمراجعة</button>
                </form>
                <a href="{{ route('cp.financial-transactions.edit', $financialTransaction) }}" class="px-4 py-2 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-medium text-sm hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">edit</span>تعديل
                </a>
            @elseif($financialTransaction->status === 'pending_review')
                <form action="{{ route('cp.financial-transactions.approve', $financialTransaction) }}" method="post" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">check_circle</span>اعتماد
                    </button>
                </form>
                <button type="button" id="reject-btn" class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-medium text-sm">رفض</button>
            @elseif($financialTransaction->status === 'approved')
                <form action="{{ route('cp.financial-transactions.complete', $financialTransaction) }}" method="post" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm">تسجيل كمكتمل</button>
                </form>
            @endif
        </div>
        @endif
    </div>

    <div id="reject-form" class="hidden rounded-2xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4">
        <form action="{{ route('cp.financial-transactions.reject', $financialTransaction) }}" method="post">
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
            <h2 class="text-lg font-bold text-slate-800 dark:text-white">{{ $financialTransaction->beneficiary_name }}</h2>
            @php $st = \App\Models\FinancialTransaction::statuses(); $sc = match($financialTransaction->status) { 'approved','completed' => 'bg-emerald-500/20 text-emerald-700 dark:text-emerald-400', 'rejected' => 'bg-red-500/20 text-red-600 dark:text-red-400', 'pending_review' => 'bg-amber-500/20 text-amber-600 dark:text-amber-400', default => 'bg-slate-200 dark:bg-slate-600 text-slate-600 dark:text-slate-300' }; @endphp
            <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $sc }}">{{ $st[$financialTransaction->status] ?? $financialTransaction->status }}</span>
        </div>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
            <div><dt class="text-slate-500 dark:text-slate-400">النوع</dt><dd class="font-medium text-slate-800 dark:text-white">{{ \App\Models\FinancialTransaction::types()[$financialTransaction->type] ?? $financialTransaction->type }}</dd></div>
            <div><dt class="text-slate-500 dark:text-slate-400">المبلغ</dt><dd class="font-bold text-lg text-primary">{{ number_format($financialTransaction->amount, 2) }} {{ $financialTransaction->currency }}</dd></div>
            <div><dt class="text-slate-500 dark:text-slate-400">التاريخ</dt><dd class="font-medium text-slate-800 dark:text-white">{{ $financialTransaction->transaction_date?->format('Y-m-d') ?? '—' }}</dd></div>
            <div><dt class="text-slate-500 dark:text-slate-400">نوع المستفيد</dt><dd class="font-medium text-slate-800 dark:text-white">{{ \App\Models\FinancialTransaction::beneficiaryTypes()[$financialTransaction->beneficiary_type] ?? $financialTransaction->beneficiary_type }}</dd></div>
            <div><dt class="text-slate-500 dark:text-slate-400">طريقة الدفع</dt><dd class="font-medium text-slate-800 dark:text-white">{{ \App\Models\FinancialTransaction::paymentMethods()[$financialTransaction->payment_method] ?? $financialTransaction->payment_method }}</dd></div>
            @if($financialTransaction->bank_reference)<div><dt class="text-slate-500 dark:text-slate-400">المرجع البنكي</dt><dd class="font-medium text-slate-800 dark:text-white">{{ $financialTransaction->bank_reference }}</dd></div>@endif
            <div class="sm:col-span-2"><dt class="text-slate-500 dark:text-slate-400">الغرض</dt><dd class="font-medium text-slate-800 dark:text-white">{{ $financialTransaction->purpose }}</dd></div>
            @if(isset($financialTransaction->loadReference) && $financialTransaction->loadReference)
                <div class="sm:col-span-2"><dt class="text-slate-500 dark:text-slate-400">مرتبط بطلب منحة</dt><dd class="font-medium text-slate-800 dark:text-white">{{ $financialTransaction->loadReference->applicant_name }} — {{ $financialTransaction->loadReference->scholarship?->title_ar ?? '—' }}</dd></div>
            @endif
            @if($financialTransaction->approved_at)<div><dt class="text-slate-500 dark:text-slate-400">تاريخ الاعتماد</dt><dd class="font-medium text-slate-800 dark:text-white">{{ $financialTransaction->approved_at->format('Y-m-d H:i') }}</dd></div>@endif
            @if($financialTransaction->approver)<div><dt class="text-slate-500 dark:text-slate-400">المُعتمِد</dt><dd class="font-medium text-slate-800 dark:text-white">{{ $financialTransaction->approver->name ?? $financialTransaction->approver->email ?? '—' }}</dd></div>@endif
            @if($financialTransaction->creator)<div><dt class="text-slate-500 dark:text-slate-400">أنشأ بواسطة</dt><dd class="font-medium text-slate-800 dark:text-white">{{ $financialTransaction->creator->name ?? $financialTransaction->creator->email ?? '—' }}</dd></div>@endif
            @if($financialTransaction->rejection_reason)<div class="sm:col-span-2"><dt class="text-slate-500 dark:text-slate-400">سبب الرفض</dt><dd class="font-medium text-red-600 dark:text-red-400">{{ $financialTransaction->rejection_reason }}</dd></div>@endif
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
