@extends('website.layout')
@section('title', localized($scholarship, 'title'))

@section('content')
<div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mb-8">
        <a class="hover:text-primary transition-colors" href="{{ localized_route('home') }}">{{ __('ui.nav_home') }}</a>
        <span class="material-symbols-outlined text-xs rtl:rotate-180">chevron_left</span>
        <a class="hover:text-primary transition-colors" href="{{ localized_route('grants.index') }}">{{ __('ui.nav_grants') }}</a>
        <span class="material-symbols-outlined text-xs rtl:rotate-180">chevron_left</span>
        <span class="text-slate-900 dark:text-white font-semibold">{{ localized($scholarship, 'title') }}</span>
    </nav>
    @php
        $endDate = $scholarship->application_end_date;
        $daysLeft = $endDate ? now()->diffInDays($endDate, false) : null;
        $isClosed = $endDate && $daysLeft !== null && $daysLeft <= 0;
        $covMin = $scholarship->coverage_percentage_min ?? $scholarship->coverage_percentage;
        $covMax = $scholarship->coverage_percentage_max ?? $scholarship->coverage_percentage;
        $hasCoverage = $covMin !== null || $covMax !== null;
    @endphp
    <div class="mb-14">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight text-slate-900 dark:text-white">
                    {{ localized($scholarship, 'title') }}
                </h1>
                @if(localized($scholarship, 'summary'))
                <p class="text-xl text-slate-600 dark:text-slate-400 leading-relaxed">
                    {{ localized($scholarship, 'summary') }}
                </p>
                @endif
            </div>
            <div class="flex flex-col gap-3 flex-wrap">
                @if($scholarship->application_form_pdf_path)
                <a href="{{ asset('storage/' . $scholarship->application_form_pdf_path) }}" target="_blank" rel="noopener"
                    class="bg-white dark:bg-card-dark border border-slate-200 dark:border-white/10 hover:border-primary px-8 py-4 rounded-xl font-bold flex items-center justify-center gap-2 transition-all shadow-sm text-slate-900 dark:text-white">
                    {{ __('ui.download_grants_pdf') }}
                    <span class="material-symbols-outlined text-[20px] text-primary">download</span>
                </a>
                @endif
                @if($isClosed)
                <span class="px-8 py-4 rounded-xl font-bold flex items-center justify-center gap-2 bg-slate-200 dark:bg-white/10 text-slate-500 dark:text-slate-400 cursor-not-allowed border border-slate-200 dark:border-white/10">
                    {{ app()->getLocale() === 'ar' ? 'قدم طلبك الآن' : 'Apply now' }}
                    <span class="material-symbols-outlined text-lg">lock</span>
                </span>
                @else
                <a href="{{ localized_route('grants.apply', ['slug' => current_slug($scholarship)]) }}"
                    class="bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-xl font-bold flex items-center justify-center gap-2 transition-all shadow-lg shadow-primary/20">
                    {{ app()->getLocale() === 'ar' ? 'قدم طلبك الآن' : 'Apply now' }}
                    <span class="material-symbols-outlined text-[20px] rtl:rotate-180">arrow_back</span>
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 mb-20">
        {{-- بطاقة واحدة لفترة التقديم والموعد النهائي --}}
        <div class="bg-white dark:bg-card-dark p-8 rounded-2xl border border-slate-200 dark:border-white/10 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute top-0 end-0 w-32 h-32 bg-primary/5 rounded-bl-full -translate-y-8 translate-x-8"></div>
            <div class="relative z-10 flex items-start gap-6">
                <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center shrink-0 text-primary">
                    <span class="material-symbols-outlined text-3xl">event_available</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-slate-500 dark:text-slate-400 text-sm mb-2 font-medium">{{ app()->getLocale() === 'ar' ? 'فترة التقديم والموعد النهائي' : 'Application period & deadline' }}</p>
                    <div class="flex flex-wrap items-baseline gap-x-2 gap-y-1">
                        @if($scholarship->application_start_date)
                            <span class="text-xl font-bold text-slate-900 dark:text-white">{{ $scholarship->application_start_date->locale(app()->getLocale())->translatedFormat('d M Y') }}</span>
                            @if($scholarship->application_end_date)
                                <span class="text-primary font-bold">→</span>
                                <span class="text-xl font-bold text-slate-900 dark:text-white">{{ $scholarship->application_end_date->locale(app()->getLocale())->translatedFormat('d M Y') }}</span>
                            @endif
                        @elseif($scholarship->application_end_date)
                            <span class="text-xl font-bold text-slate-900 dark:text-white">{{ $scholarship->application_end_date->locale(app()->getLocale())->translatedFormat('d F Y') }}</span>
                        @else
                            <span class="text-slate-400">—</span>
                        @endif
                    </div>
                    @if($endDate)
                    <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl {{ $isClosed ? 'bg-slate-100 dark:bg-white/5 text-slate-500 dark:text-slate-400' : 'bg-primary/10 text-primary' }}">
                        <span class="material-symbols-outlined text-lg">{{ $isClosed ? 'lock' : 'schedule' }}</span>
                        <span class="text-sm font-bold">{{ $isClosed ? __('ui.apply_ended') : ($daysLeft <= 14 ? __('ui.days_left_apply', ['days' => max(1, (int) round($daysLeft))]) : __('ui.open')) }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        {{-- بطاقة نسبة التغطية أو حالة المنحة --}}
        @if($hasCoverage)
        <div class="bg-white dark:bg-card-dark p-8 rounded-2xl border border-slate-200 dark:border-white/10 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute bottom-0 start-0 w-32 h-32 bg-primary/5 rounded-tr-full translate-y-8 -translate-x-8"></div>
            <div class="relative z-10 flex items-start gap-6">
                <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center shrink-0 text-primary">
                    <span class="material-symbols-outlined text-3xl">percent</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-slate-500 dark:text-slate-400 text-sm mb-3 font-medium">{{ __('ui.grants_coverage_label') }}</p>
                    <div class="flex items-center gap-2 flex-wrap">
                        @if($covMin !== null && $covMax !== null && $covMin != $covMax)
                            <span class="text-slate-500 dark:text-slate-400 text-sm">{{ __('ui.grants_coverage_from') }}</span>
                            <span class="inline-flex items-center justify-center min-w-[2.5rem] px-2 py-1 rounded-lg bg-primary/10 dark:bg-primary/15 text-primary font-bold text-lg border border-primary/20">{{ $covMin }}%</span>
                            <span class="text-slate-500 dark:text-slate-400 text-sm">{{ __('ui.grants_coverage_to') }}</span>
                            <span class="inline-flex items-center justify-center min-w-[2.5rem] px-2 py-1 rounded-lg bg-primary/10 dark:bg-primary/15 text-primary font-bold text-lg border border-primary/20">{{ $covMax }}%</span>
                        @else
                            <span class="inline-flex items-center justify-center min-w-[2.5rem] px-2 py-1 rounded-lg bg-primary/10 dark:bg-primary/15 text-primary font-bold text-xl border border-primary/20">{{ $covMin ?? $covMax }}%</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white dark:bg-card-dark p-8 rounded-2xl border border-slate-200 dark:border-white/10 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute bottom-0 start-0 w-32 h-32 bg-primary/5 rounded-tr-full translate-y-8 -translate-x-8"></div>
            <div class="relative z-10 flex items-center gap-6">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center shrink-0 {{ $isClosed ? 'bg-slate-100 dark:bg-white/5 text-slate-500' : 'bg-primary/10 text-primary' }}">
                    <span class="material-symbols-outlined text-3xl">{{ $isClosed ? 'check_circle' : 'task_alt' }}</span>
                </div>
                <div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mb-1 font-medium">{{ app()->getLocale() === 'ar' ? 'حالة التقديم' : 'Application status' }}</p>
                    <p class="text-2xl font-bold {{ $isClosed ? 'text-slate-500 dark:text-slate-400' : 'text-primary' }}">
                        {{ $isClosed ? __('ui.closed') : __('ui.open') }}
                    </p>
                    @if(!$isClosed && $daysLeft !== null && $daysLeft <= 14)
                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-1 font-bold flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">timer</span>
                        {{ __('ui.days_left_apply', ['days' => max(1, (int) round($daysLeft))]) }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="space-y-20">
        @if(localized($scholarship, 'details'))
        <section>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-1.5 h-10 bg-primary rounded-full"></div>
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white">{{ app()->getLocale() === 'ar' ? 'وصف المنحة' : 'Scholarship description' }}</h2>
            </div>
            <div class="prose prose-slate dark:prose-invert max-w-none">
                <div class="text-slate-600 dark:text-slate-400 leading-loose text-xl whitespace-pre-line">{{ localized($scholarship, 'details') }}</div>
            </div>
        </section>
        @endif
        @if(localized($scholarship, 'conditions'))
        <section>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-1.5 h-10 bg-primary rounded-full"></div>
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white">{{ app()->getLocale() === 'ar' ? 'شروط الأهلية' : 'Eligibility' }}</h2>
            </div>
            <div class="prose prose-slate dark:prose-invert max-w-none">
                <div class="text-slate-600 dark:text-slate-400 leading-loose text-lg whitespace-pre-line">{{ localized($scholarship, 'conditions') }}</div>
            </div>
        </section>
        @endif
        @if(localized($scholarship, 'required_documents'))
        <section>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-1.5 h-10 bg-primary rounded-full"></div>
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white">{{ app()->getLocale() === 'ar' ? 'الأوراق المطلوبة' : 'Required documents' }}</h2>
            </div>
            <div class="prose prose-slate dark:prose-invert max-w-none">
                <div class="text-slate-600 dark:text-slate-400 leading-loose text-lg whitespace-pre-line">{{ localized($scholarship, 'required_documents') }}</div>
            </div>
        </section>
        @endif
        <section class="bg-primary/5 border border-primary/20 p-10 md:p-16 rounded-[2.5rem] text-center relative overflow-hidden">
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-primary/10 rounded-full blur-3xl"></div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-4xl font-extrabold mb-6 text-slate-900 dark:text-white">{{ app()->getLocale() === 'ar' ? 'جاهز للبدء في رحلتك؟' : 'Ready to start your journey?' }}</h2>
                <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 mb-12 max-w-2xl mx-auto leading-relaxed">
                    {{ app()->getLocale() === 'ar' ? 'تأكد من تجهيز كافة الوثائق المطلوبة قبل البدء في تعبئة طلب التقديم.' : 'Make sure you have all required documents before filling out the application.' }}
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                    @if($isClosed)
                    <span class="w-full sm:w-auto bg-slate-300 dark:bg-white/10 text-slate-500 dark:text-slate-400 px-12 py-5 rounded-2xl font-bold text-xl flex items-center justify-center gap-3 cursor-not-allowed opacity-80">
                        {{ app()->getLocale() === 'ar' ? 'قدم طلبك الآن' : 'Apply now' }}
                        <span class="material-symbols-outlined">lock</span>
                    </span>
                    @else
                    <a href="{{ localized_route('grants.apply', ['slug' => current_slug($scholarship)]) }}"
                        class="w-full sm:w-auto bg-primary hover:bg-opacity-90 text-white px-12 py-5 rounded-2xl font-bold text-xl flex items-center justify-center gap-3 transition-all shadow-2xl shadow-primary/30">
                        {{ app()->getLocale() === 'ar' ? 'قدم طلبك الآن' : 'Apply now' }}
                        <span class="material-symbols-outlined rtl:rotate-180">arrow_back</span>
                    </a>
                    @endif
                </div>
            </div>
        </section>
        @if($related->isNotEmpty())
        <section>
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-8">{{ app()->getLocale() === 'ar' ? 'منح ذات صلة' : 'Related scholarships' }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($related as $r)
                <a href="{{ localized_route('grants.show', ['slug' => current_slug($r)]) }}"
                    class="bg-white dark:bg-card-dark p-6 rounded-2xl border border-slate-200 dark:border-white/10 hover:border-primary/50 transition-all shadow-sm hover:shadow-md block">
                    @if($r->image_path)
                    <img src="{{ asset('storage/' . $r->image_path) }}" alt="{{ localized($r, 'title') }}" class="w-full h-40 object-cover rounded-xl mb-4" loading="lazy" width="400" height="300" />
                    @endif
                    <h3 class="font-bold text-lg text-slate-900 dark:text-white group-hover:text-primary">{{ localized($r, 'title') }}</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mt-2">{{ Str::limit(localized($r, 'summary'), 80) }}</p>
                </a>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>

@push('scripts')
{{-- Structured Data (Schema.org) for Scholarship --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Scholarship",
    "name": @json(localized($scholarship, 'title')),
    "description": {{ json_encode(Str::limit(strip_tags(localized($scholarship, 'summary') ?? localized($scholarship, 'title')), 200)) }},
    "provider": {
        "@type": "Organization",
        "name": {{ json_encode(__('ui.site_name')) }},
        "url": "{{ url('/') }}"
    },
    @if($scholarship->image_path)
    "image": "{{ asset('storage/' . $scholarship->image_path) }}",
    @endif
    "url": "{{ url()->current() }}",
    "applicationDeadline": "{{ $scholarship->application_end_date?->toIso8601String() }}",
    @if($scholarship->application_start_date)
    "startDate": "{{ $scholarship->application_start_date->toIso8601String() }}",
    @endif
    @if($scholarship->estimated_value)
    "value": {
        "@type": "MonetaryAmount",
        "currency": "USD",
        "value": "{{ $scholarship->estimated_value }}"
    },
    @endif
    "inLanguage": "{{ app()->getLocale() === 'ar' ? 'ar' : 'en' }}"
}
</script>

{{-- Breadcrumb Structured Data --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": {{ json_encode(__('ui.home')) }},
            "item": "{{ localized_route('home') }}"
        },
        {
            "@type": "ListItem",
            "position": 2,
            "name": {{ json_encode(__('ui.nav_grants')) }},
            "item": "{{ localized_route('grants.index') }}"
        },
        {
            "@type": "ListItem",
            "position": 3,
            "name": @json(localized($scholarship, 'title')),
            "item": "{{ url()->current() }}"
        }
    ]
}
</script>
@endpush
@endsection
