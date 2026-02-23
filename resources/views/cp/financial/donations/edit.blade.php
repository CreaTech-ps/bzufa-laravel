@extends('cp.layout')

@section('title', 'تعديل تبرع')

@section('content')
<div class="w-full max-w-2xl space-y-6">
    <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
        <a href="{{ route('cp.donations.index') }}" class="hover:text-primary">التبرعات</a>
        <span class="material-symbols-outlined text-lg">chevron_left</span>
        <a href="{{ route('cp.donations.show', $donation) }}" class="hover:text-primary">عرض</a>
        <span class="material-symbols-outlined text-lg">chevron_left</span>
        <span>تعديل</span>
    </div>

    <form action="{{ route('cp.donations.update', $donation) }}" method="post" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm space-y-4">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="donor_name" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">اسم المتبرع *</label>
                <input type="text" name="donor_name" id="donor_name" value="{{ old('donor_name', $donation->donor_name) }}" required class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
                @error('donor_name')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="donor_type" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">نوع المتبرع *</label>
                <select name="donor_type" id="donor_type" required class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
                    @foreach(\App\Models\Donation::donorTypes() as $v => $l)
                        <option value="{{ $v }}" {{ old('donor_type', $donation->donor_type) === $v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="donor_email" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">البريد الإلكتروني</label>
                <input type="email" name="donor_email" id="donor_email" value="{{ old('donor_email', $donation->donor_email) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
            </div>
            <div>
                <label for="donor_phone" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">الهاتف</label>
                <input type="text" name="donor_phone" id="donor_phone" value="{{ old('donor_phone', $donation->donor_phone) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="amount" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">المبلغ *</label>
                <input type="number" name="amount" id="amount" value="{{ old('amount', $donation->amount) }}" step="0.01" min="0.01" required class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
                @error('amount')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="currency" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">العملة</label>
                <select name="currency" id="currency" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
                    <option value="ILS" {{ old('currency', $donation->currency) === 'ILS' ? 'selected' : '' }}>ILS</option>
                    <option value="USD" {{ old('currency', $donation->currency) === 'USD' ? 'selected' : '' }}>USD</option>
                    <option value="EUR" {{ old('currency', $donation->currency) === 'EUR' ? 'selected' : '' }}>EUR</option>
                </select>
            </div>
            <div>
                <label for="donation_date" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">تاريخ التبرع *</label>
                <input type="date" name="donation_date" id="donation_date" value="{{ old('donation_date', $donation->donation_date?->format('Y-m-d')) }}" required class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="donation_method" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">طريقة التبرع *</label>
                <select name="donation_method" id="donation_method" required class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
                    @foreach(\App\Models\Donation::donationMethods() as $v => $l)
                        <option value="{{ $v }}" {{ old('donation_method', $donation->donation_method) === $v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="reference_number" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">الرقم المرجعي</label>
                <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number', $donation->reference_number) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
            </div>
        </div>
        <div>
            <label for="purpose" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">الغرض</label>
            <select name="purpose" id="purpose" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">
                <option value="">اختر</option>
                @foreach(\App\Models\Donation::purposes() as $v => $l)
                    <option value="{{ $v }}" {{ old('purpose', $donation->purpose) === $v ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="notes" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">ملاحظات</label>
            <textarea name="notes" id="notes" rows="3" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">{{ old('notes', $donation->notes) }}</textarea>
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ route('cp.donations.show', $donation) }}" class="px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">إلغاء</a>
            <button type="submit" class="cp-btn px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-white font-medium shadow-sm transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-xl">save</span>
                حفظ
            </button>
        </div>
    </form>
</div>
@endsection
