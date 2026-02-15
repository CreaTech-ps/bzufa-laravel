@extends('website.layout')
@section('title', $scholarship->title_ar)

@section('content')
<div class="max-w-6xl mx-auto px-8 lg:px-16 py-16">
    <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mb-8">
        <a class="hover:text-primary transition-colors" href="{{ route('home') }}">الرئيسية</a>
        <span class="material-symbols-outlined text-xs">chevron_left</span>
        <a class="hover:text-primary transition-colors" href="{{ route('grants.index') }}">المنح الدراسية</a>
        <span class="material-symbols-outlined text-xs">chevron_left</span>
        <span class="text-slate-900 dark:text-white font-semibold">{{ $scholarship->title_ar }}</span>
    </nav>
    <div class="mb-14">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight text-slate-900 dark:text-white">
                    {{ $scholarship->title_ar }}
                </h1>
                @if($scholarship->summary_ar)
                <p class="text-xl text-slate-600 dark:text-slate-400 leading-relaxed">
                    {{ $scholarship->summary_ar }}
                </p>
                @endif
            </div>
            @if($scholarship->application_form_pdf_path)
            <div class="flex flex-wrap gap-4">
                <a href="{{ asset('storage/' . $scholarship->application_form_pdf_path) }}" target="_blank" rel="noopener"
                    class="bg-white dark:bg-card-dark border border-slate-200 dark:border-white/10 hover:border-primary px-8 py-4 rounded-xl font-bold flex items-center gap-2 transition-all shadow-sm text-slate-900 dark:text-white">
                    تحميل ملف المنحة (PDF)
                    <span class="material-symbols-outlined text-[20px] text-primary">download</span>
                </a>
            </div>
            @endif
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 mb-20">
        @if($scholarship->application_start_date || $scholarship->application_end_date)
        <div class="bg-white dark:bg-card-dark p-8 rounded-2xl border border-slate-200 dark:border-white/10 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mb-6 text-primary">
                <span class="material-symbols-outlined text-3xl">event</span>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm mb-1 font-medium">فترة التقديم</p>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                @if($scholarship->application_start_date)
                    {{ $scholarship->application_start_date->translatedFormat('d/m/Y') }}
                @else
                    —
                @endif
                @if($scholarship->application_end_date)
                    <span class="text-primary">→</span> {{ $scholarship->application_end_date->translatedFormat('d/m/Y') }}
                @endif
            </h3>
        </div>
        @endif
        <div class="bg-white dark:bg-card-dark p-8 rounded-2xl border border-slate-200 dark:border-white/10 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mb-6 text-primary">
                <span class="material-symbols-outlined text-3xl">event_busy</span>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm mb-1 font-medium">الموعد النهائي</p>
            <h3 class="text-3xl font-bold text-slate-900 dark:text-white">
                {{ $scholarship->application_end_date ? $scholarship->application_end_date->translatedFormat('d F Y') : '—' }}
            </h3>
            @if($scholarship->application_end_date && $scholarship->application_end_date->isFuture())
            @php $daysLeft = now()->diffInDays($scholarship->application_end_date, false); @endphp
            @if($daysLeft <= 14)
            <p class="text-xs text-red-500 mt-2 font-bold flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">timer</span>
                متبقي {{ $daysLeft }} يوم للتقديم
            </p>
            @endif
            @endif
        </div>
    </div>
    <div class="space-y-20">
        @if($scholarship->details_ar)
        <section>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-1.5 h-10 bg-primary rounded-full"></div>
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white">وصف المنحة</h2>
            </div>
            <div class="prose prose-slate dark:prose-invert max-w-none">
                <div class="text-slate-600 dark:text-slate-400 leading-loose text-xl whitespace-pre-line">{{ $scholarship->details_ar }}</div>
            </div>
        </section>
        @endif
        @if($scholarship->conditions_ar)
        <section>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-1.5 h-10 bg-primary rounded-full"></div>
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white">شروط الأهلية</h2>
            </div>
            <div class="prose prose-slate dark:prose-invert max-w-none">
                <div class="text-slate-600 dark:text-slate-400 leading-loose text-lg whitespace-pre-line">{{ $scholarship->conditions_ar }}</div>
            </div>
        </section>
        @endif
        @if($scholarship->required_documents_ar)
        <section>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-1.5 h-10 bg-primary rounded-full"></div>
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white">الأوراق المطلوبة</h2>
            </div>
            <div class="prose prose-slate dark:prose-invert max-w-none">
                <div class="text-slate-600 dark:text-slate-400 leading-loose text-lg whitespace-pre-line">{{ $scholarship->required_documents_ar }}</div>
            </div>
        </section>
        @endif
        <section class="bg-primary/5 border border-primary/20 p-10 md:p-16 rounded-[2.5rem] text-center relative overflow-hidden">
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-primary/10 rounded-full blur-3xl"></div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-4xl font-extrabold mb-6 text-slate-900 dark:text-white">جاهز للبدء في رحلتك؟</h2>
                <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 mb-12 max-w-2xl mx-auto leading-relaxed">
                    تأكد من تجهيز كافة الوثائق المطلوبة قبل البدء في تعبئة طلب التقديم.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                    <a href="{{ route('grants.apply', $scholarship->slug_ar ?: $scholarship->id) }}"
                        class="w-full sm:w-auto bg-primary hover:bg-opacity-90 text-white px-12 py-5 rounded-2xl font-bold text-xl flex items-center justify-center gap-3 transition-all shadow-2xl shadow-primary/30">
                        قدم طلبك الآن
                        <span class="material-symbols-outlined">arrow_back</span>
                    </a>
                </div>
            </div>
        </section>
        @if($related->isNotEmpty())
        <section>
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-8">منح ذات صلة</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($related as $r)
                <a href="{{ route('grants.show', $r->slug_ar ?: $r->id) }}"
                    class="bg-white dark:bg-card-dark p-6 rounded-2xl border border-slate-200 dark:border-white/10 hover:border-primary/50 transition-all shadow-sm hover:shadow-md block">
                    @if($r->image_path)
                    <img src="{{ asset('storage/' . $r->image_path) }}" alt="{{ $r->title_ar }}" class="w-full h-40 object-cover rounded-xl mb-4" />
                    @endif
                    <h3 class="font-bold text-lg text-slate-900 dark:text-white group-hover:text-primary">{{ $r->title_ar }}</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mt-2">{{ Str::limit($r->summary_ar, 80) }}</p>
                </a>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>
@endsection
