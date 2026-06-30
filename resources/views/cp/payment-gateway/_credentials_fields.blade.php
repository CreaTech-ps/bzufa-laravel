@php
    $secretKeys = \App\Models\PaymentGatewaySetting::secretKeys();
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">المفتاح العام (Public Key)</label>
        <input type="text" name="{{ $prefix }}[public_key]" value="{{ old($prefix.'.public_key', $credentials['public_key'] ?? '') }}"
            class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 dir-ltr text-start" autocomplete="off">
    </div>
    <div>
        <label class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">المفتاح السري (Secret Key)</label>
        <input type="password" name="{{ $prefix }}[secret_key]" value=""
            placeholder="{{ $settings->hasStoredSecret($mode, 'secret_key') ? '●●●●●●●● (محفوظ — اتركه فارغاً للإبقاء)' : 'أدخل المفتاح السري' }}"
            class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 dir-ltr text-start" autocomplete="new-password">
    </div>
    <div>
        <label class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">معرّف صفحة الدفع (Page ID)</label>
        <input type="text" name="{{ $prefix }}[page_id]" value="{{ old($prefix.'.page_id', $credentials['page_id'] ?? '') }}"
            class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 dir-ltr text-start">
    </div>
    <div>
        <label class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">رابط صفحة الدفع الكامل (اختياري)</label>
        <input type="url" name="{{ $prefix }}[payment_page_url]" value="{{ old($prefix.'.payment_page_url', $credentials['payment_page_url'] ?? '') }}"
            placeholder="https://pay.lahza.io/..."
            class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 dir-ltr text-start">
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">إن وُجد، يُستخدم بدلاً من Page ID.</p>
    </div>
    <div>
        <label class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">سر Webhook</label>
        <input type="password" name="{{ $prefix }}[webhook_secret]" value=""
            placeholder="{{ $settings->hasStoredSecret($mode, 'webhook_secret') ? '●●●●●●●● (محفوظ — اتركه فارغاً للإبقاء)' : 'أدخل سر Webhook' }}"
            class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 dir-ltr text-start" autocomplete="new-password">
    </div>
    <div>
        <label class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">رابط API</label>
        <input type="url" name="{{ $prefix }}[api_base_url]" value="{{ old($prefix.'.api_base_url', $credentials['api_base_url'] ?? 'https://api.lahza.io') }}"
            class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 dir-ltr text-start">
    </div>
    <div>
        <label class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">رابط Checkout</label>
        <input type="url" name="{{ $prefix }}[checkout_url]" value="{{ old($prefix.'.checkout_url', $credentials['checkout_url'] ?? 'https://pay.lahza.io') }}"
            class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 dir-ltr text-start">
    </div>
    <div>
        <label class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">رابط النجاح (Success URL)</label>
        <input type="url" name="{{ $prefix }}[success_url]" value="{{ old($prefix.'.success_url', $credentials['success_url'] ?? '') }}"
            placeholder="اتركه فارغاً لاستخدام callback الافتراضي"
            class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 dir-ltr text-start">
    </div>
    <div class="md:col-span-2">
        <label class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">رابط الإلغاء (Cancel URL)</label>
        <input type="url" name="{{ $prefix }}[cancel_url]" value="{{ old($prefix.'.cancel_url', $credentials['cancel_url'] ?? '') }}"
            placeholder="اتركه فارغاً لاستخدام callback الافتراضي"
            class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 dir-ltr text-start">
    </div>
</div>

<p class="text-xs text-slate-500 dark:text-slate-400 pt-2 border-t border-slate-200 dark:border-slate-600">
    الحقول الفارغة في قاعدة البيانات تُكمَّل تلقائياً من ملف <code class="bg-slate-100 dark:bg-slate-700 px-1 rounded">.env</code> إن وُجدت هناك.
</p>
