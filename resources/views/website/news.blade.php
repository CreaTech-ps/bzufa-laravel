@extends('website.layout')

@section('title', 'أرشيف الأخبار والتقارير')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-12 xl:px-16 pt-8 pb-20">
    <nav class="flex items-center text-xs gap-2 text-slate-500 dark:text-slate-400 mb-6">
        <a class="hover:text-primary transition-colors" href="{{ route('home') }}">الرئيسية</a>
        <span class="material-symbols-outlined text-[14px]">chevron_left</span>
        <span class="text-text-dark-gray dark:text-white font-semibold">أرشيف الأخبار والتقارير</span>
    </nav>

    <section
        class="hero-gradient-news relative w-full h-[280px] rounded-3xl overflow-hidden mb-12 flex flex-col items-center justify-center text-center px-6 shadow-xl border border-white/10">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-4">أرشيف الأخبار والتقارير</h1>
        <p class="text-slate-200 max-w-2xl text-base md:text-lg leading-relaxed">
            تصفح سجل نشاطاتنا، إنجازاتنا، وتقارير الشفافية التي توثق أثر تبرعاتكم منذ التأسيس ودورنا في دعم مسيرة
            التعليم.
        </p>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        {{-- لوحة التصفية --}}
        <aside class="lg:col-span-3 order-2 lg:order-1 lg:sticky lg:top-28">
            <div
                class="bg-white dark:bg-bg-dark-card p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800">
                <div class="flex items-center gap-2 mb-6 text-primary">
                    <span class="material-symbols-outlined">filter_list</span>
                    <h2 class="text-lg font-bold">تصفية النتائج</h2>
                </div>
                <form method="GET" action="{{ route('news.index') }}" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium mb-2 text-slate-600 dark:text-slate-400">اختر العام</label>
                        <select name="year"
                            class="w-full bg-slate-50 dark:bg-bg-dark-main border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 focus:ring-primary focus:border-primary transition-all cursor-pointer text-sm dark:text-slate-300">
                            <option value="">كل الأعوام</option>
                            @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2 text-slate-600 dark:text-slate-400">الشهر</label>
                        <select name="month"
                            class="w-full bg-slate-50 dark:bg-bg-dark-main border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 focus:ring-primary focus:border-primary transition-all cursor-pointer text-sm dark:text-slate-300">
                            <option value="">كل الأشهر</option>
                            @foreach(['01' => 'يناير', '02' => 'فبراير', '03' => 'مارس', '04' => 'أبريل', '05' => 'مايو', '06' => 'يونيو', '07' => 'يوليو', '08' => 'أغسطس', '09' => 'سبتمبر', '10' => 'أكتوبر', '11' => 'نوفمبر', '12' => 'ديسمبر'] as $num => $name)
                            <option value="{{ $num }}" {{ request('month') == $num ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex-1 bg-primary hover:brightness-110 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                            تطبيق الفلاتر
                        </button>
                        @if(request()->hasAny(['year', 'month']))
                        <a href="{{ route('news.index') }}"
                            class="px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors"
                            title="مسح الكل">✕</a>
                        @endif
                    </div>
                </form>
            </div>
        </aside>

        {{-- قائمة الأخبار --}}
        <section class="lg:col-span-9 order-1 lg:order-2">
            {{-- الفلاتر النشطة --}}
            @if(request()->hasAny(['year', 'month']))
            <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-slate-500 dark:text-slate-400 text-sm font-medium">الفلاتر النشطة:</span>
                    @if(request('year'))
                    <span
                        class="inline-flex items-center gap-2 bg-primary/10 text-primary px-3 py-1.5 rounded-full text-xs font-bold border border-primary/20">
                        عام {{ request('year') }}
                    </span>
                    @endif
                    @if(request('month'))
                    @php
                    $months = ['01' => 'يناير', '02' => 'فبراير', '03' => 'مارس', '04' => 'أبريل', '05' => 'مايو', '06' => 'يونيو', '07' => 'يوليو', '08' => 'أغسطس', '09' => 'سبتمبر', '10' => 'أكتوبر', '11' => 'نوفمبر', '12' => 'ديسمبر'];
                    @endphp
                    <span
                        class="inline-flex items-center gap-2 bg-primary/10 text-primary px-3 py-1.5 rounded-full text-xs font-bold border border-primary/20">
                        {{ $months[request('month')] ?? request('month') }}
                    </span>
                    @endif
                </div>
                <a href="{{ route('news.index') }}"
                    class="text-sm font-bold text-slate-500 hover:text-primary transition-colors">مسح الكل</a>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($news as $item)
                <article
                    class="bg-white dark:bg-bg-dark-card rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 hover:shadow-xl transition-all group flex flex-col">
                    <a href="{{ route('news.show', $item->slug_ar ?: $item->id) }}" class="block">
                        <div class="relative h-44 overflow-hidden">
                            <img alt="{{ $item->title_ar }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                src="{{ $item->image_path ? asset('storage/' . $item->image_path) : 'https://via.placeholder.com/400x200?text=خبر' }}" />
                        </div>
                    </a>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex items-center gap-2 text-slate-400 text-[11px] mb-3">
                            <span class="material-symbols-outlined text-sm">calendar_month</span>
                            {{ $item->published_at?->locale('ar')->translatedFormat('d F Y') ?? '—' }}
                        </div>
                        <h3 class="text-base font-bold mb-3 leading-tight group-hover:text-primary transition-colors">
                            <a href="{{ route('news.show', $item->slug_ar ?: $item->id) }}">{{ $item->title_ar }}</a>
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed line-clamp-3 mb-6">
                            {{ Str::limit($item->summary_ar ?? $item->title_ar, 120) }}
                        </p>
                        <div
                            class="flex items-center justify-between mt-auto border-t border-slate-100 dark:border-slate-800/50 pt-4">
                            <a class="flex items-center gap-1 text-primary font-bold text-xs hover:translate-x-[-4px] transition-transform"
                                href="{{ route('news.show', $item->slug_ar ?: $item->id) }}">
                                اقرأ المزيد
                                <span class="material-symbols-outlined text-sm">arrow_back</span>
                            </a>
                            <button type="button" data-url="{{ url(route('news.show', $item->slug_ar ?: $item->id)) }}"
                                onclick="navigator.clipboard.writeText(this.dataset.url)"
                                class="text-slate-400 hover:text-primary transition-colors share-btn" title="نسخ الرابط">
                                <span class="material-symbols-outlined text-lg">share</span>
                            </button>
                        </div>
                    </div>
                </article>
                @empty
                <div class="col-span-full text-center py-16 text-slate-500 dark:text-slate-400">
                    <span class="material-symbols-outlined text-6xl mb-4 block opacity-50">newspaper</span>
                    <p class="text-lg font-medium">لا توجد أخبار مطابقة للبحث</p>
                    <a href="{{ route('news.index') }}" class="inline-block mt-4 text-primary font-bold hover:underline">عرض جميع الأخبار</a>
                </div>
                @endforelse
            </div>

            {{-- الترقيم --}}
            @if($news->hasPages())
            <nav class="flex justify-center items-center gap-3 mt-16">
                {{ $news->links('pagination::tailwind') }}
            </nav>
            @endif
        </section>
    </div>
</div>
@endsection
