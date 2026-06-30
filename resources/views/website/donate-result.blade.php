@extends('website.layout')

@section('content')
<section class="py-16 md:py-20 px-4 sm:px-6 lg:px-8 bg-slate-50 dark:bg-[#151515] min-h-[70vh]">
    <div class="main-container max-w-2xl">
        @php
            $status = $donation?->status;
            $isSuccess = $status === 'approved';
            $isFailed = in_array($status, ['rejected', 'refunded'], true);
        @endphp

        <div class="bg-white dark:bg-card-dark rounded-2xl p-8 border border-slate-200 dark:border-white/10 shadow-sm text-center">
            <div class="mb-4">
                @if($isSuccess)
                    <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-100 text-emerald-600">
                        <span class="material-symbols-outlined text-3xl">check_circle</span>
                    </span>
                @elseif($isFailed)
                    <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 text-red-600">
                        <span class="material-symbols-outlined text-3xl">cancel</span>
                    </span>
                @else
                    <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 text-amber-600">
                        <span class="material-symbols-outlined text-3xl">schedule</span>
                    </span>
                @endif
            </div>

            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-2">
                @if($isSuccess)
                    {{ __('donate.result_success_title') }}
                @elseif($isFailed)
                    {{ __('donate.result_failed_title') }}
                @else
                    {{ __('donate.result_pending_title') }}
                @endif
            </h1>

            <p class="text-slate-600 dark:text-slate-400 @if(!$isSuccess && !$isFailed) mb-4 @else mb-6 @endif">
                @if($isSuccess)
                    {{ __('donate.result_success_body') }}
                @elseif($isFailed)
                    {{ __('donate.result_failed_body') }}
                @else
                    {{ __('donate.result_pending_body') }}
                @endif
            </p>

            @if(!$isSuccess && !$isFailed)
                <div class="mb-6 rounded-xl border border-blue-200 dark:border-blue-900/50 bg-blue-50/80 dark:bg-blue-950/30 p-4 text-sm text-slate-700 dark:text-slate-300 text-start leading-relaxed">
                    <p class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl shrink-0">mail</span>
                        <span>{{ __('donate.result_pending_invoice_note') }}</span>
                    </p>
                </div>
            @endif

            @if($donation)
                <div id="donation-receipt" class="text-sm bg-slate-50 dark:bg-slate-800 rounded-xl p-4 text-start">
                    <h2 class="font-bold text-slate-900 dark:text-white mb-3">تفاصيل العملية</h2>
                    <p class="mb-1"><span class="font-bold">المرجع:</span> {{ $donation->reference_number }}</p>
                    <p class="mb-1"><span class="font-bold">المبلغ:</span> {{ number_format($donation->amount, 2) }} {{ $donation->currency }}</p>
                    <p class="mb-1"><span class="font-bold">التاريخ:</span> {{ $donation->donation_date?->format('Y-m-d') ?? $donation->created_at?->format('Y-m-d') }}</p>
                    @if($donation->gateway_transaction_id)
                        <p class="mb-1"><span class="font-bold">رقم العملية الإلكترونية:</span> {{ $donation->gateway_transaction_id }}</p>
                    @endif
                    <p><span class="font-bold">الحالة:</span> {{ \App\Models\Donation::statuses()[$donation->status] ?? $donation->status }}</p>
                </div>
            @endif

            <div class="mt-6 flex items-center justify-center gap-3">
                <a href="{{ localized_route('donate.form') }}" class="bg-primary text-white px-6 py-2.5 rounded-full font-bold">
                    تبرع جديد
                </a>
                <a href="{{ localized_route('home') }}" class="px-6 py-2.5 rounded-full border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300">
                    الصفحة الرئيسية
                </a>
                @if($donation)
                    <button type="button" onclick="window.print()" class="px-6 py-2.5 rounded-full border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300">
                        طباعة الإيصال
                    </button>
                    <a href="{{ localized_route('donate.receipt', ['reference' => $donation->reference_number]) }}" class="px-6 py-2.5 rounded-full border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300">
                        تنزيل PDF
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
