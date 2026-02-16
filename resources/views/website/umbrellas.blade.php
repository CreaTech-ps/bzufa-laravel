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
                        <span id="parasols-count-text">{{ $totalSpaces }} مساحة معروضة حالياً</span>
                    </div>
                </div>
                @if($regions->isNotEmpty())
                <div
                    class="flex flex-wrap items-center gap-2 p-1.5 bg-gray-100 dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800"
                    id="parasols-filter">
                    @php $currentRegion = request('region') ? (int)request('region') : null; @endphp
                    <button type="button" class="parasols-filter-btn px-7 py-2.5 rounded-lg font-semibold dark:text-gray-300 transition-all hover:bg-gray-200 dark:hover:bg-gray-800 {{ !$currentRegion ? 'bg-primary text-white font-bold shadow-md' : '' }}"
                        data-region="">الكل</button>
                    @foreach($regions as $region)
                    <button type="button" class="parasols-filter-btn px-7 py-2.5 rounded-lg font-semibold dark:text-gray-300 transition-all hover:bg-gray-200 dark:hover:bg-gray-800 {{ $currentRegion === (int)$region->id ? 'bg-primary text-white font-bold shadow-md' : '' }}"
                        data-region="{{ $region->id }}">{{ $region->name_ar }}</button>
                    @endforeach
                </div>
                @endif
            </div>
            <div id="parasols-grid-wrap">
                @include('website.partials.parasols_spaces', ['images' => $images, 'totalSpaces' => $totalSpaces])
            </div>
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

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
(function() {
    var spacesUrl = @json(route('parasols.spaces'));
    var $wrap = $('#parasols-grid-wrap');
    var $countText = $('#parasols-count-text');
    var $filterBtns = $('.parasols-filter-btn');

    function setActiveBtn(regionId) {
        $filterBtns.removeClass('bg-primary text-white font-bold shadow-md').addClass('hover:bg-gray-200 dark:hover:bg-gray-800');
        $filterBtns.filter(function() {
            return $(this).data('region') === regionId || ($(this).data('region') === '' && !regionId);
        }).addClass('bg-primary text-white font-bold shadow-md').removeClass('hover:bg-gray-200 dark:hover:bg-gray-800');
    }

    $filterBtns.on('click', function() {
        var regionId = $(this).data('region');
        setActiveBtn(regionId === '' ? null : regionId);
        $wrap.addClass('opacity-60 pointer-events-none');
        $.ajax({
            url: spacesUrl,
            type: 'GET',
            data: { region: regionId || undefined },
            dataType: 'json',
            success: function(data) {
                $wrap.html(data.html).removeClass('opacity-60 pointer-events-none');
                if ($countText.length) $countText.text(data.total + ' مساحة معروضة حالياً');
            },
            error: function() {
                $wrap.removeClass('opacity-60 pointer-events-none');
            }
        });
    });
})();
</script>
@endsection
