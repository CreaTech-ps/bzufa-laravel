@extends('cp.layout')

@section('title', 'إدارة النصوص والمحتوى')

@section('content')
<div class="flex flex-col lg:flex-row gap-6">
    {{-- شريط المجموعات --}}
    <aside class="lg:w-56 shrink-0">
        <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-3 shadow-sm">
            <p class="px-3 py-2 text-xs font-medium text-slate-500 dark:text-slate-400 uppercase">الأقسام</p>
            <nav class="space-y-0.5">
                @foreach($groups as $slug => $group)
                    <a href="{{ route('cp.site-texts.index', ['group' => $slug]) }}"
                        class="block px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ $currentGroup === $slug ? 'bg-primary/15 text-primary dark:bg-primary/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                        {{ $group['label_ar'] ?? $slug }}
                    </a>
                @endforeach
            </nav>
        </div>
    </aside>

    {{-- نموذج النصوص --}}
    <main class="flex-1 min-w-0">
        <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-lg font-bold text-slate-800 dark:text-white">{{ $labels['ar'] ?? $currentGroup }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">عدّل العناوين والفقرات والعبارات لهذا القسم</p>
            </div>

            <form action="{{ route('cp.site-texts.update') }}" method="post" class="p-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="group" value="{{ $currentGroup }}" />

                <div class="space-y-6">
                    @foreach($items as $key => $item)
                        @php $text = $texts[$key] ?? null; @endphp
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ $item['label_ar'] ?? $key }}
                                <span class="text-xs font-normal text-slate-400">({{ $key }})</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <textarea name="values[{{ $loop->index }}][ar]" rows="2" placeholder="النص بالعربية"
                                        class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 text-sm resize-y">{{ old("values.{$loop->index}.ar", $text?->value_ar ?? __($key, [], 'ar')) }}</textarea>
                                </div>
                                <div>
                                    <textarea name="values[{{ $loop->index }}][en]" rows="2" placeholder="English text"
                                        class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 text-sm resize-y">{{ old("values.{$loop->index}.en", $text?->value_en ?? __($key, [], 'en')) }}</textarea>
                                </div>
                            </div>
                            @if(mb_strlen($item['label_ar'] ?? '') > 0 && mb_strlen($item['label_ar']) > 60)
                                <p class="mt-1 text-xs text-slate-500">يمكن استخدام نصوص طويلة (فقرات) في الحقول أعلاه.</p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="cp-btn inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-white font-medium shadow-sm">
                        <span class="material-symbols-outlined text-xl">save</span>
                        حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
