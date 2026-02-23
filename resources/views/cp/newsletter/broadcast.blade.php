@extends('cp.layout')

@section('title', 'إرسال رسالة جماعية')

@section('content')
<div class="space-y-6 max-w-2xl">
    <div>
        <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-1">إرسال رسالة جماعية</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">سيتم إرسال الرسالة إلى جميع مشتركي النشرة الإخبارية المسجلين.</p>
    </div>

    @if(session('success'))
    <div class="rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/50 p-4 text-emerald-700 dark:text-emerald-400">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('cp.newsletter.send') }}" method="post" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm space-y-6">
        @csrf

        <div>
            <label for="subject" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">الموضوع</label>
            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-3 focus:ring-2 focus:ring-primary/30"
                placeholder="عنوان الرسالة">
            @error('subject')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="body" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">نص الرسالة</label>
            <textarea name="body" id="body" rows="10" required
                class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-3 focus:ring-2 focus:ring-primary/30 resize-y"
                placeholder="اكتب رسالتك هنا...">{{ old('body') }}</textarea>
            <p class="mt-1 text-xs text-slate-400">يدعم سطر جديد. لن يتم تفسير HTML.</p>
            @error('body')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-white font-medium flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">send</span>
                إرسال للجميع
            </button>
            <a href="{{ route('cp.newsletter.index') }}" class="text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 text-sm">العودة للمشتركين</a>
        </div>
    </form>
</div>
@endsection
