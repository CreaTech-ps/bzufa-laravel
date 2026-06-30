@extends('cp.layout')

@section('title', 'بوابة الدفع والتبرع')

@section('content')
@php
    $testCreds = $settings->credentialsFor('test');
    $liveCreds = $settings->credentialsFor('live');
@endphp
<div class="w-full max-w-4xl space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 dark:text-white">بوابة الدفع والتبرع</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">إدارة بيانات Lahza، التبديل بين الاختبار والإنتاج، وإيقاف/تفعيل التبرع الإلكتروني.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            @if($settings->donations_enabled)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    التبرع مفعّل
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    التبرع موقوف
                </span>
            @endif
            @if($activeMode === 'test')
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200">
                    <span class="material-symbols-outlined text-sm">science</span>
                    وضع الاختبار نشط
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200">
                    <span class="material-symbols-outlined text-sm">verified</span>
                    الوضع الرسمي نشط
                </span>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('cp.payment-gateway.update') }}" method="post" class="space-y-6" id="payment-gateway-form">
        @csrf
        @method('PUT')

        {{-- التحكم العام --}}
        <section class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm space-y-6">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">tune</span>
                التحكم العام
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="rounded-xl border border-slate-200 dark:border-slate-600 p-4">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="donations_enabled" value="1" class="mt-1 rounded border-slate-300 text-primary focus:ring-primary"
                            {{ old('donations_enabled', $settings->donations_enabled) ? 'checked' : '' }}>
                        <span>
                            <span class="block font-bold text-slate-800 dark:text-white">إتاحة التبرع الإلكتروني</span>
                            <span class="block text-sm text-slate-500 dark:text-slate-400 mt-1">عند الإيقاف، تُخفى صفحة التبرع عن الزوار ويُرفض إتمام أي عملية دفع.</span>
                        </span>
                    </label>
                </div>

                <div class="rounded-xl border border-slate-200 dark:border-slate-600 p-4">
                    <p class="font-bold text-slate-800 dark:text-white mb-3">البوابة المستخدمة حالياً</p>
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="active_mode" value="test" class="peer sr-only"
                                {{ old('active_mode', $settings->active_mode) === 'test' ? 'checked' : '' }}>
                            <span class="flex flex-col items-center gap-1 p-3 rounded-xl border-2 border-slate-200 dark:border-slate-600 peer-checked:border-amber-500 peer-checked:bg-amber-50 dark:peer-checked:bg-amber-950/30 transition-colors text-center">
                                <span class="material-symbols-outlined text-amber-600">science</span>
                                <span class="text-sm font-bold text-slate-800 dark:text-white">اختبار</span>
                            </span>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="active_mode" value="live" class="peer sr-only"
                                {{ old('active_mode', $settings->active_mode) === 'live' ? 'checked' : '' }}>
                            <span class="flex flex-col items-center gap-1 p-3 rounded-xl border-2 border-slate-200 dark:border-slate-600 peer-checked:border-primary peer-checked:bg-primary/5 dark:peer-checked:bg-primary/10 transition-colors text-center">
                                <span class="material-symbols-outlined text-primary">verified</span>
                                <span class="text-sm font-bold text-slate-800 dark:text-white">رسمي</span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 p-4">
                <p class="text-sm font-bold text-slate-700 dark:text-slate-200 mb-1 flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">link</span>
                    رابط Webhook (انسخه إلى لوحة Lahza)
                </p>
                <div class="flex gap-2 mt-2">
                    <input type="text" readonly value="{{ $webhookUrl }}" id="webhook-url"
                        class="cp-input flex-1 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 px-3 py-2 text-sm font-mono dir-ltr text-start">
                    <button type="button" id="copy-webhook" class="px-4 py-2 rounded-lg bg-slate-200 dark:bg-slate-600 hover:bg-slate-300 dark:hover:bg-slate-500 text-sm font-medium transition-colors">
                        نسخ
                    </button>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">يُستخدم سر Webhook الخاص بالوضع النشط (اختبار أو رسمي) للتحقق من الإشعارات.</p>
            </div>
        </section>

        {{-- بيانات الربط --}}
        <section class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="border-b border-slate-200 dark:border-slate-700 px-6 pt-4">
                <h2 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2 mb-4">
                    <span class="material-symbols-outlined text-primary">credit_card</span>
                    بيانات الربط
                </h2>
                <div class="flex gap-1" role="tablist">
                    <button type="button" class="pg-tab px-4 py-2.5 text-sm font-bold rounded-t-xl border-b-2 border-amber-500 text-amber-700 dark:text-amber-300 bg-amber-50/50 dark:bg-amber-950/20" data-tab="test">
                        بيانات الاختبار
                    </button>
                    <button type="button" class="pg-tab px-4 py-2.5 text-sm font-bold rounded-t-xl border-b-2 border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300" data-tab="live">
                        بيانات الرسمي
                    </button>
                </div>
            </div>

            <div class="p-6">
                <div id="tab-test" class="pg-panel space-y-4">
                    @include('cp.payment-gateway._credentials_fields', [
                        'prefix' => 'test_credentials',
                        'credentials' => $testCreds,
                        'settings' => $settings,
                        'mode' => 'test',
                    ])
                </div>
                <div id="tab-live" class="pg-panel hidden space-y-4">
                    @include('cp.payment-gateway._credentials_fields', [
                        'prefix' => 'live_credentials',
                        'credentials' => $liveCreds,
                        'settings' => $settings,
                        'mode' => 'live',
                    ])
                </div>
            </div>
        </section>

        @if(!$resolved['secret_key'])
            <div class="rounded-xl border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-950/30 p-4 text-sm text-amber-900 dark:text-amber-200">
                <strong>تنبيه:</strong> الوضع النشط حالياً لا يحتوي على مفتاح سري. أدخل بيانات الربط أو تأكد من وجودها في ملف <code class="bg-amber-100 dark:bg-amber-900/50 px-1 rounded">.env</code> كاحتياط.
            </div>
        @endif

        <div class="flex justify-end">
            <button type="submit" class="cp-btn px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-white font-medium shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-xl">save</span>
                حفظ الإعدادات
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('.pg-tab');
    var panels = {
        test: document.getElementById('tab-test'),
        live: document.getElementById('tab-live'),
    };

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            var target = tab.getAttribute('data-tab');
            tabs.forEach(function(t) {
                t.classList.remove('border-amber-500', 'border-primary', 'text-amber-700', 'dark:text-amber-300', 'text-primary', 'bg-amber-50/50', 'dark:bg-amber-950/20', 'bg-primary/5', 'dark:bg-primary/10');
                t.classList.add('border-transparent', 'text-slate-500');
            });
            Object.values(panels).forEach(function(p) { p.classList.add('hidden'); });
            panels[target].classList.remove('hidden');
            if (target === 'test') {
                tab.classList.add('border-amber-500', 'text-amber-700', 'dark:text-amber-300', 'bg-amber-50/50', 'dark:bg-amber-950/20');
            } else {
                tab.classList.add('border-primary', 'text-primary', 'bg-primary/5', 'dark:bg-primary/10');
            }
            tab.classList.remove('border-transparent', 'text-slate-500');
        });
    });

    var copyBtn = document.getElementById('copy-webhook');
    var webhookInput = document.getElementById('webhook-url');
    if (copyBtn && webhookInput) {
        copyBtn.addEventListener('click', function() {
            webhookInput.select();
            webhookInput.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(webhookInput.value).then(function() {
                copyBtn.textContent = 'تم النسخ';
                setTimeout(function() { copyBtn.textContent = 'نسخ'; }, 2000);
            });
        });
    }
});
</script>
@endpush
@endsection
