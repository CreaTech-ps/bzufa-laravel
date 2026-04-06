@extends('website.layout')

@section('title', __('donate.page_title'))

@section('content')
<section id="donate-return-policy" class="py-16 md:py-20 px-4 sm:px-6 lg:px-8 bg-slate-50 dark:bg-[#151515] min-h-[70vh]">
    <div class="main-container max-w-3xl">
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-2">{{ __('donate.page_title') }}</h1>
            <p class="text-slate-600 dark:text-slate-400">{{ __('donate.intro') }}</p>
        </div>

        <div class="mb-6 rounded-2xl border border-amber-200 dark:border-amber-900/50 bg-amber-50/80 dark:bg-amber-950/30 p-4 text-sm text-slate-800 dark:text-slate-200">
            <p class="font-bold text-amber-900 dark:text-amber-200 mb-1">{{ __('donate.policy_donation_title') }}</p>
            <p class="leading-relaxed text-slate-700 dark:text-slate-300">{{ __('donate.policy_donation_body') }}</p>
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
                    <label class="block text-sm mb-1 text-slate-700 dark:text-slate-300">{{ __('donate.amount_label') }} *</label>
                    <input type="number" name="amount" value="{{ old('amount') }}" min="0.01" step="0.01" required class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2.5">
                    @error('amount')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm mb-1 text-slate-700 dark:text-slate-300">{{ __('donate.currency_label') }}</label>
                    <select name="currency" class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2.5">
                        <option value="ILS" {{ old('currency', 'ILS') === 'ILS' ? 'selected' : '' }}>ILS</option>
                        <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD</option>
                        <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm mb-1 text-slate-700 dark:text-slate-300">{{ __('donate.purpose_label') }}</label>
                    <select name="purpose" class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2.5">
                        <option value="">{{ __('donate.purpose_general') }}</option>
                        @foreach(\App\Models\Donation::purposes() as $v => $l)
                            <option value="{{ $v }}" {{ old('purpose') === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                {{ __('donate.gateway_note') }}
            </p>
            <div>
                <label class="block text-sm mb-1 text-slate-700 dark:text-slate-300">{{ __('donate.notes_label') }}</label>
                <textarea name="notes" rows="3" class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2.5">{{ old('notes') }}</textarea>
            </div>

            <div class="flex items-start gap-3 rounded-xl border border-slate-200 dark:border-slate-600 p-4">
                <input type="checkbox" name="accept_policies" id="accept_policies" value="1" class="mt-1 rounded border-slate-300 text-primary" {{ old('accept_policies') ? 'checked' : '' }} required>
                <label for="accept_policies" class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed">
                    {!! __('donate.accept_policies_html', [
                        'return' => '<a href="#donate-return-policy" class="text-primary font-semibold underline underline-offset-2">' . e(__('donate.return_policy_link')) . '</a>',
                        'privacy' => '<a href="' . e(localized_route('privacy')) . '" class="text-primary font-semibold underline underline-offset-2" target="_blank" rel="noopener">' . e(__('donate.privacy_link')) . '</a>',
                    ]) !!}
                </label>
            </div>
            @error('accept_policies')<p class="text-sm text-red-600">{{ $message }}</p>@enderror

            @if(!empty($recaptchaSiteKey))
                <div>
                    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                    <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
                    @error('g-recaptcha-response')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                </div>
            @endif

            <div class="pt-2">
                <button type="submit" class="bg-primary text-white px-8 py-3 rounded-full font-bold hover:brightness-110 transition-all">
                    {{ __('donate.submit') }}
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
