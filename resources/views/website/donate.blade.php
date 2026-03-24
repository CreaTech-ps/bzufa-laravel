@extends('website.layout')

@section('content')
<section class="py-16 md:py-20 px-4 sm:px-6 lg:px-8 bg-slate-50 dark:bg-[#151515] min-h-[70vh]">
    <div class="main-container max-w-3xl">
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-2">التبرع الإلكتروني</h1>
            <p class="text-slate-600 dark:text-slate-400">يمكنك إتمام التبرع بأمان عبر بوابة الدفع الإلكترونية.</p>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('donate.checkout') }}" method="post" class="bg-white dark:bg-card-dark rounded-2xl p-6 border border-slate-200 dark:border-white/10 shadow-sm space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm mb-1 text-slate-700 dark:text-slate-300">المبلغ *</label>
                    <input type="number" name="amount" value="{{ old('amount') }}" min="0.01" step="0.01" required class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2.5">
                    @error('amount')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm mb-1 text-slate-700 dark:text-slate-300">العملة</label>
                    <select name="currency" class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2.5">
                        <option value="ILS" {{ old('currency', 'ILS') === 'ILS' ? 'selected' : '' }}>ILS</option>
                        <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD</option>
                        <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm mb-1 text-slate-700 dark:text-slate-300">الغرض</label>
                    <select name="purpose" class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2.5">
                        <option value="">عام</option>
                        @foreach(\App\Models\Donation::purposes() as $v => $l)
                            <option value="{{ $v }}" {{ old('purpose') === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                سيتم إدخال بيانات المتبرع (الاسم/البريد/الهاتف) داخل صفحة بوابة الدفع مباشرة.
            </p>
            <div>
                <label class="block text-sm mb-1 text-slate-700 dark:text-slate-300">ملاحظات</label>
                <textarea name="notes" rows="3" class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2.5">{{ old('notes') }}</textarea>
            </div>
            <div class="pt-2">
                <button type="submit" class="bg-primary text-white px-8 py-3 rounded-full font-bold hover:brightness-110 transition-all">
                    متابعة الدفع
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
