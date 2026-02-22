@extends('cp.layout')

@section('title', 'إعدادات مشروع تمكين - قطاعات شركاء الأثر والنجاح')

@section('content')
<div class="w-full max-w-3xl space-y-6">
    <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
        <a href="{{ route('cp.tamkeen.partnerships.index') }}" class="hover:text-primary">تمكين</a>
        <span class="material-symbols-outlined text-lg">chevron_left</span>
        <span>قطاعات شركاء الأثر والنجاح</span>
    </div>

    <form action="{{ route('cp.tamkeen.settings.update') }}" method="post" class="space-y-6" id="sectors-form">
        @csrf
        @method('PUT')

        <section class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-2 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">category</span>
                قطاعات شركاء الأثر والنجاح
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">تتحكم هذه القطاعات في قائمة التصفية في صفحة مشروع تمكين، وفي خيارات القطاع عند إضافة شراكة جديدة.</p>

            <div id="sectors-container" class="space-y-4">
                @foreach(($settings->sectors ?? \App\Models\TamkeenSetting::defaultSectors()) as $idx => $sector)
                <div class="sector-row flex gap-3 items-start p-4 rounded-xl bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600">
                    <input type="text" name="sectors[{{ $idx }}][key]" value="{{ old('sectors.'.$idx.'.key', $sector['key'] ?? '') }}" placeholder="مفتاح (مثل: tech)" required class="cp-input w-28 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm" />
                    <input type="text" name="sectors[{{ $idx }}][label_ar]" value="{{ old('sectors.'.$idx.'.label_ar', $sector['label_ar'] ?? '') }}" placeholder="العنوان (عربي)" required class="cp-input flex-1 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm" />
                    <input type="text" name="sectors[{{ $idx }}][label_en]" value="{{ old('sectors.'.$idx.'.label_en', $sector['label_en'] ?? '') }}" placeholder="Label (English)" required class="cp-input flex-1 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm" />
                    <button type="button" class="remove-sector p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="حذف">
                        <span class="material-symbols-outlined text-xl">delete</span>
                    </button>
                </div>
                @endforeach
            </div>

            <button type="button" id="add-sector-btn" class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-dashed border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-400 hover:border-primary hover:text-primary transition-colors text-sm font-medium">
                <span class="material-symbols-outlined text-xl">add</span>
                إضافة قطاع
            </button>
        </section>

        <div class="flex justify-end">
            <button type="submit" class="cp-btn px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-white font-medium shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-xl">save</span>
                حفظ التغييرات
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var container = document.getElementById('sectors-container');
    var addBtn = document.getElementById('add-sector-btn');
    var idx = container.querySelectorAll('.sector-row').length;

    addBtn.addEventListener('click', function() {
        var html = '<div class="sector-row flex gap-3 items-start p-4 rounded-xl bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600">' +
            '<input type="text" name="sectors[' + idx + '][key]" placeholder="مفتاح (مثل: tech)" required class="cp-input w-28 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm" />' +
            '<input type="text" name="sectors[' + idx + '][label_ar]" placeholder="العنوان (عربي)" required class="cp-input flex-1 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm" />' +
            '<input type="text" name="sectors[' + idx + '][label_en]" placeholder="Label (English)" required class="cp-input flex-1 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm" />' +
            '<button type="button" class="remove-sector p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"><span class="material-symbols-outlined text-xl">delete</span></button>' +
            '</div>';
        container.insertAdjacentHTML('beforeend', html);
        idx++;
    });

    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-sector')) {
            var row = e.target.closest('.sector-row');
            if (container.querySelectorAll('.sector-row').length > 1) {
                row.remove();
            }
        }
    });
});
</script>
@endpush
@endsection
