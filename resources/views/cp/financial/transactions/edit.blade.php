@extends('cp.layout')

@section('title', 'تعديل حركة مالية')

@section('content')
<div class="w-full max-w-2xl space-y-6">
    <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
        <a href="{{ route('cp.financial-transactions.index') }}" class="hover:text-primary">الحركات المالية</a>
        <span class="material-symbols-outlined text-lg">chevron_left</span>
        <a href="{{ route('cp.financial-transactions.show', $financialTransaction) }}" class="hover:text-primary">عرض</a>
        <span class="material-symbols-outlined text-lg">chevron_left</span>
        <span>تعديل</span>
    </div>

    <form action="{{ route('cp.financial-transactions.update', $financialTransaction) }}" method="post" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm space-y-4">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="type" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">نوع الحركة *</label>
                <select name="type" id="type" required class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
                    @foreach(\App\Models\FinancialTransaction::types() as $v => $l)
                        <option value="{{ $v }}" {{ old('type', $financialTransaction->type) === $v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div id="scholarship-wrap" class="{{ old('type', $financialTransaction->type) === 'grant_payment' ? '' : 'hidden' }}">
                <label for="scholarship_application_id" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">طلب المنحة</label>
                <select name="scholarship_application_id" id="scholarship_application_id" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
                    <option value="">— لا يوجد —</option>
                    @foreach($scholarshipApplications as $app)
                        <option value="{{ $app->id }}" {{ old('scholarship_application_id', $financialTransaction->reference_id) == $app->id ? 'selected' : '' }}>{{ $app->applicant_name }} ({{ $app->scholarship?->title_ar ?? '—' }})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="amount" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">المبلغ *</label>
                <input type="number" name="amount" id="amount" value="{{ old('amount', $financialTransaction->amount) }}" step="0.01" min="0.01" required class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
            </div>
            <div>
                <label for="currency" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">العملة</label>
                <select name="currency" id="currency" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
                    <option value="ILS" {{ old('currency', $financialTransaction->currency) === 'ILS' ? 'selected' : '' }}>ILS</option>
                    <option value="USD" {{ old('currency', $financialTransaction->currency) === 'USD' ? 'selected' : '' }}>USD</option>
                    <option value="EUR" {{ old('currency', $financialTransaction->currency) === 'EUR' ? 'selected' : '' }}>EUR</option>
                </select>
            </div>
            <div>
                <label for="transaction_date" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">التاريخ *</label>
                <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', $financialTransaction->transaction_date?->format('Y-m-d')) }}" required class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="beneficiary_name" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">اسم المستفيد *</label>
                <input type="text" name="beneficiary_name" id="beneficiary_name" value="{{ old('beneficiary_name', $financialTransaction->beneficiary_name) }}" required class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
            </div>
            <div>
                <label for="beneficiary_type" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">نوع المستفيد *</label>
                <select name="beneficiary_type" id="beneficiary_type" required class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
                    @foreach(\App\Models\FinancialTransaction::beneficiaryTypes() as $v => $l)
                        <option value="{{ $v }}" {{ old('beneficiary_type', $financialTransaction->beneficiary_type) === $v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label for="purpose" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">الغرض *</label>
            <textarea name="purpose" id="purpose" rows="3" required class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">{{ old('purpose', $financialTransaction->purpose) }}</textarea>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="payment_method" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">طريقة الدفع *</label>
                <select name="payment_method" id="payment_method" required class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
                    @foreach(\App\Models\FinancialTransaction::paymentMethods() as $v => $l)
                        <option value="{{ $v }}" {{ old('payment_method', $financialTransaction->payment_method) === $v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="bank_reference" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">المرجع البنكي</label>
                <input type="text" name="bank_reference" id="bank_reference" value="{{ old('bank_reference', $financialTransaction->bank_reference) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
            </div>
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ route('cp.financial-transactions.show', $financialTransaction) }}" class="px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">إلغاء</a>
            <button type="submit" class="cp-btn px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-white font-medium shadow-sm transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-xl">save</span>
                حفظ وإرسال للمراجعة
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.getElementById('type')?.addEventListener('change', function() {
    document.getElementById('scholarship-wrap').classList.toggle('hidden', this.value !== 'grant_payment');
});
</script>
@endpush
@endsection
