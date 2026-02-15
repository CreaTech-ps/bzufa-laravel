@extends('website.layout')
@section('title', 'مشروع المظلات - المساحات الإعلانية')

@section('content')
    <section class="hero-gradient-umbrella py-20 md:py-20 relative overflow-hidden">
        <div class="max-w-[1240px] mx-auto px-6 lg:px-12 w-full">
            <div class="text-center relative z-10">
                <div
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-primary/10 text-primary border border-primary/20 mb-8 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-xs font-bold uppercase tracking-widest">مبادرة خيرية مستدامة</span>
                </div>
                
                @php
                    $heroTitle = $settings->hero_title_ar ?? 'مشروع المظلات: ظل وعطاء';
                    $heroParts = str_contains($heroTitle, ':') ? explode(':', $heroTitle, 2) : [$heroTitle, null];
                @endphp

                <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-8 leading-[1.2]">
                    {{ trim($heroParts[0]) }}{{ $heroParts[1] ? ':' : '' }} @if($heroParts[1])<span class="text-primary">{{ trim($heroParts[1]) }}</span>@endif
                </h1>

                <p class="text-gray-300 text-lg md:text-xl max-w-3xl mx-auto mb-14 leading-relaxed opacity-90">
                    {{ $settings->hero_subtitle_ar ?? 'نجمع بين جمال الإعلان وأثر العمل الخيري، لنوفر مساحات إعلانية متميزة تخدم المجتمع وترسم مستقبلاً أفضل، حيث يعود ريع كل إعلان لدعم الطلاب.' }}
                </p>

                <div class="flex flex-wrap justify-center gap-6">
                    @if(!empty($settings->cta_primary_url))
                    <a href="{{ $settings->cta_primary_url }}" target="_blank" rel="noopener"
                        class="bg-primary text-white px-10 py-4 rounded-xl font-bold text-lg hover:shadow-2xl hover:shadow-primary/40 transition-all transform hover:-translate-y-1 inline-flex items-center justify-center">{{ $settings->cta_primary_text_ar ?? 'اكتشف المساحات' }}</a>
                    @else
                    <a href="#spaces" class="bg-primary text-white px-10 py-4 rounded-xl font-bold text-lg hover:shadow-2xl hover:shadow-primary/40 transition-all transform hover:-translate-y-1 inline-flex items-center justify-center">{{ $settings->cta_primary_text_ar ?? 'اكتشف المساحات' }}</a>
                    @endif
                    @if(!empty($settings->cta_secondary_url))
                    <a href="{{ $settings->cta_secondary_url }}" target="_blank" rel="noopener"
                        class="bg-white/10 text-white backdrop-blur-md px-10 py-4 rounded-xl font-bold text-lg border border-white/20 hover:bg-white/20 transition-all inline-flex items-center justify-center">{{ $settings->cta_secondary_text_ar ?? 'كيف يعمل المشروع؟' }}</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="relative z-20">
        <div class="max-w-[1240px] mx-auto px-6 lg:px-12 w-full">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div
                    class="bg-white dark:bg-surface-dark p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800/50 text-center transform transition-all hover:scale-[1.03]">
                    <p class="text-primary text-4xl font-black mb-1">{{ $settings->stat1_value ?? '120+' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider">{{ $settings->stat1_label_ar ?? 'مظلة مفعلة' }}</p>
                </div>
                <div
                    class="bg-white dark:bg-surface-dark p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800/50 text-center transform transition-all hover:scale-[1.03]">
                    <p class="text-primary text-4xl font-black mb-1">{{ $settings->stat2_value ?? '1500' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider">{{ $settings->stat2_label_ar ?? 'طالب مستفيد' }}</p>
                </div>
                <div
                    class="bg-white dark:bg-surface-dark p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800/50 text-center transform transition-all hover:scale-[1.03]">
                    <p class="text-primary text-4xl font-black mb-1">{{ $settings->stat3_value ?? '3' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider">{{ $settings->stat3_label_ar ?? 'مدن رئيسية' }}</p>
                </div>
                <div
                    class="bg-white dark:bg-surface-dark p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800/50 text-center transform transition-all hover:scale-[1.03]">
                    <p class="text-primary text-4xl font-black mb-1">{{ $settings->stat4_value ?? '%98' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider">{{ $settings->stat4_label_ar ?? 'نسبة الإشغال' }}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-28" id="spaces">
        <div class="max-w-[1240px] mx-auto px-6 lg:px-12 w-full">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-16 gap-8">
                <div class="max-w-xl">
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-4 dark:text-white">{{ $settings->section_title_ar ?? 'المساحات المتاحة في الحرم الجامعي' }}</h2>
                    <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400 font-medium">
                        <span class="material-symbols-outlined text-primary">filter_list</span>
                        <span>{{ $totalSpaces }} مساحة معروضة حالياً</span>
                    </div>
                </div>
                @if($regions->isNotEmpty())
                <div
                    class="flex flex-wrap items-center gap-2 p-1.5 bg-gray-100 dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800">
                    <a href="{{ route('parasols.index') }}"
                        class="px-7 py-2.5 rounded-lg {{ !request('region') ? 'bg-primary text-white font-bold shadow-md' : 'hover:bg-gray-200 dark:hover:bg-gray-800 transition-all font-semibold dark:text-gray-300' }}">الكل</a>
                    @foreach($regions as $region)
                    <a href="{{ route('parasols.index', ['region' => $region->id]) }}"
                        class="px-7 py-2.5 rounded-lg {{ request('region') == $region->id ? 'bg-primary text-white font-bold shadow-md' : 'hover:bg-gray-200 dark:hover:bg-gray-800 transition-all font-semibold dark:text-gray-300' }}">{{ $region->name_ar }}</a>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($images as $item)
                <div
                    class="bg-white dark:bg-surface-dark rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800/50 group transition-all hover:shadow-2xl">
                    <div class="relative h-64 overflow-hidden">
                        <img alt="{{ $item->title_ar }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('assets/img/logo-l.svg') }}" />
                        <div class="absolute top-4 right-4">
                            @if($item->status === 'ending_soon')
                            <span
                                class="bg-orange-500 text-white text-[10px] font-black px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-lg">
                                <span class="material-symbols-outlined text-xs">timer</span>
                                ينتهي قريباً
                            </span>
                            @else
                            <span
                                class="bg-green-500 text-white text-[10px] font-black px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-lg">
                                <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                متاح حالياً
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold group-hover:text-primary transition-colors dark:text-white">{{ $item->title_ar }}</h3>
                            <p class="text-primary font-black text-xl">${{ $item->price ?? '—' }}<span class="text-xs text-gray-500 font-normal">/شهر</span></p>
                        </div>
                        @if($item->location_ar)
                        <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400 text-sm mb-7">
                            <span class="material-symbols-outlined text-sm">location_on</span>
                            <span>{{ $item->location_ar }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-16 text-slate-500 dark:text-slate-400">
                    لا توجد مساحات معروضة حالياً
                </div>
                @endforelse
            </div>
            @if($images->hasPages())
            <div class="mt-16 text-center">
                {{ $images->links('pagination::tailwind') }}
            </div>
            @endif
        </div>
    </section>
    <section class="pb-32">
        <div class="max-w-[1240px] mx-auto px-6 lg:px-12 w-full">
            <div
                class="bg-primary/5 dark:bg-primary/10 rounded-[2.5rem] p-12 md:p-24 text-center border border-primary/10 dark:border-primary/20 relative overflow-hidden shadow-sm">
                <div class="absolute -top-10 -right-10 p-12 opacity-[0.03] dark:opacity-[0.08]">
                    <span class="material-symbols-outlined text-[20rem] text-primary">campaign</span>
                </div>
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-5xl font-black mb-8 leading-tight dark:text-white">هل ترغب في حجز مساحتك الإعلانية؟</h2>
                    <p class="text-gray-600 dark:text-gray-300 text-lg md:text-xl max-w-3xl mx-auto mb-16 leading-relaxed font-medium">
                        كن شريكاً في دعم تعليم الطلاب من خلال استثمار مساحتك الإعلانية معنا. ريع هذا المشروع بالكامل مخصص للمنح الدراسية والمساعدات الطلابية.
                    </p>
                    <div class="flex flex-wrap justify-center gap-6">
                        <button
                            class="bg-primary text-white px-10 py-4 rounded-xl font-bold text-lg hover:shadow-2xl hover:shadow-primary/40 transition-all transform hover:-translate-y-1 inline-flex items-center justify-center gap-3">
                            تواصل معنا الآن
                            <span class="material-symbols-outlined">send</span>
                        </button>
                        <button
                            class="bg-white dark:bg-surface-dark text-slate-800 dark:text-white px-10 py-4 rounded-xl font-bold text-lg border border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all inline-flex items-center justify-center gap-3">
                            تحميل ملف المشروع (PDF)
                            <span class="material-symbols-outlined">download</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
