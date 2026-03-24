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
                    شكرا لكم، تمت عملية التبرع بنجاح
                @elseif($isFailed)
                    لم تكتمل عملية التبرع
                @else
                    عملية التبرع قيد التحقق
                @endif
            </h1>

            <p class="text-slate-600 dark:text-slate-400 mb-6">
                @if($isSuccess)
                    تم تسجيل تبرعكم بنجاح، وسيصل أثر دعمكم مباشرة إلى برامج الجمعية.
                @elseif($isFailed)
                    يمكنكم إعادة المحاولة أو التواصل معنا إذا تم الخصم دون تحديث الحالة.
                @else
                    جار استلام تأكيد الدفع من البوابة. يرجى تحديث الصفحة بعد لحظات.
                @endif
            </p>

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
