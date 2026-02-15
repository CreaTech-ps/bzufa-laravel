@extends('website.layout')
@section('title', 'مشروع التمكين - تمكين طلابنا لسوق العمل')

@section('content')
<main class="max-w-6xl mx-auto px-6 md:px-8 lg:px-8">
    <section
        class="hero-enable-bg relative rounded-3xl overflow-hidden min-h-[480px] flex items-center px-8 md:px-16 mb-16">
        <div class="max-w-2xl text-white">
            <div
                class="inline-flex items-center gap-2 bg-primary/20 backdrop-blur-sm border border-primary/30 px-3 py-1 rounded-full text-xs font-bold mb-6">
                <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
                مبادرة التمكين المهني
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                تمكين طلابنا <br /> <span class="text-primary">لسوق العمل</span>
            </h1>
            <p class="text-lg text-slate-300 leading-relaxed mb-10">
                نسد الفجوة بين التعليم الأكاديمي والاحتياجات الفعلية لقطاع الأعمال من خلال شراكات استراتيجية مع رواد
                الصناعة في المملكة، لضمان مستقبل مهني واعد لخريجينا.
            </p>
            <div class="flex flex-wrap gap-4">
                <button
                    class="bg-primary hover:bg-opacity-90 text-white px-8 py-4 rounded-xl font-bold transition-all shadow-lg shadow-primary/20">
                    انضم إلينا كشريك
                </button>
                <button
                    class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white px-8 py-4 rounded-xl font-bold transition-all">
                    تصفح دليل الشركاء
                </button>
            </div>
        </div>
    </section>
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-20">
        <div
            class="bg-white dark:bg-card-dark p-8 rounded-2xl border border-gray-100 dark:border-white/5 shadow-sm transition-transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-2">
                <span class="text-primary font-bold text-sm">طالب مستفيد</span>
                <span class="material-symbols-outlined text-primary">school</span>
            </div>
            <div class="text-4xl font-extrabold mb-2">{{ $totalBeneficiaries > 0 ? number_format($totalBeneficiaries) . '+' : '1,500+' }}</div>
            <p class="text-sm text-slate-500 dark:text-slate-400">متدرب تم تأهيلهم لسوق العمل مباشرة خلال العام الماضي</p>
        </div>
        <div
            class="bg-white dark:bg-card-dark p-8 rounded-2xl border border-gray-100 dark:border-white/5 shadow-sm transition-transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-2">
                <span class="text-primary font-bold text-sm">شريك استراتيجي</span>
                <span class="material-symbols-outlined text-primary">corporate_fare</span>
            </div>
            <div class="text-4xl font-extrabold mb-2">{{ $totalPartnerships > 0 ? $totalPartnerships . '+' : '45+' }}</div>
            <p class="text-sm text-slate-500 dark:text-slate-400">من كبرى الشركات الوطنية والعالمية في مختلف القطاعات</p>
        </div>
        <div
            class="bg-white dark:bg-card-dark p-8 rounded-2xl border border-gray-100 dark:border-white/5 shadow-sm transition-transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-2">
                <span class="text-primary font-bold text-sm">ساعة تدريبية</span>
                <span class="material-symbols-outlined text-primary">schedule</span>
            </div>
            <div class="text-4xl font-extrabold mb-2">10,000+</div>
            <p class="text-sm text-slate-500 dark:text-slate-400">تدريب ميداني وتطبيقي مكثف في بيئات عمل حقيقية</p>
        </div>
    </section>
    <section class="mb-24">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <h2 class="text-3xl font-bold mb-3">شركاء الأثر والنجاح</h2>
                <p class="text-slate-500 dark:text-slate-400 max-w-xl">نعتز بشراكتنا مع نخبة من المؤسسات التي تساهم في صياغة مستقبل الكوادر الوطنية، مستعرضين هنا حجم الأثر المحقق لكل شريك.</p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($partnerships as $item)
            @if($item->link)
            <a href="{{ $item->link }}" target="_blank" rel="noopener"
                class="bg-white dark:bg-card-dark rounded-2xl p-6 border border-gray-100 dark:border-white/5 hover:border-primary/50 transition-all flex flex-col items-center text-center group block">
            @else
            <div
                class="bg-white dark:bg-card-dark rounded-2xl p-6 border border-gray-100 dark:border-white/5 hover:border-primary/50 transition-all flex flex-col items-center text-center group">
            @endif
                <div
                    class="w-20 h-20 bg-gray-50 dark:bg-accent-dark rounded-xl flex items-center justify-center mb-6 overflow-hidden group-hover:scale-110 transition-transform">
                    @if($item->logo_path)
                    <img alt="{{ $item->supporter_name_ar }}" class="w-12 h-auto dark:invert opacity-80"
                        src="{{ asset('storage/' . $item->logo_path) }}" />
                    @else
                    <span class="material-symbols-outlined text-4xl text-slate-300">business</span>
                    @endif
                </div>
                <h3 class="font-bold text-lg mb-1">{{ $item->supporter_name_ar }}</h3>
                <p class="text-xs text-slate-400 mb-6">&nbsp;</p>
                <div
                    class="w-full bg-gray-50 dark:bg-accent-dark rounded-xl p-4 flex items-center justify-between mb-4">
                    <div class="text-right">
                        <span class="block text-2xl font-black text-primary">{{ $item->beneficiaries_count ?? '—' }}</span>
                        <span class="text-[10px] text-slate-400 uppercase tracking-tighter">طالب تم تمكينهم</span>
                    </div>
                    @if($item->start_date)
                    <div class="text-left text-[10px] text-slate-500">منذ<br />{{ $item->start_date->format('Y/m') }}</div>
                    @endif
                </div>
                <div class="flex items-center gap-1.5 text-[10px] font-bold text-primary">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                    نشط حالياً
                </div>
            @if($item->link)
            </a>
            @else
            </div>
            @endif
            @empty
            <div class="col-span-full text-center py-16 text-slate-500 dark:text-slate-400">
                لا توجد شراكات معروضة حالياً
            </div>
            @endforelse
        </div>
        @if($partnerships->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $partnerships->links('pagination::tailwind') }}
        </div>
        @endif
    </section>
    <section
        class="bg-primary rounded-[2.5rem] p-8 md:p-14 flex flex-col md:flex-row items-center justify-between gap-8 mb-20 relative overflow-hidden shadow-2xl shadow-primary/10">
        <div
            class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl">
        </div>
        <div class="relative z-10 text-center md:text-right">
            <h2 class="text-white text-3xl md:text-4xl font-extrabold mb-4">هل تريد صناعة أثر حقيقي؟</h2>
            <p class="text-white/80 max-w-lg leading-relaxed text-sm md:text-base">
                انضم إلى شبكة شركائنا وساهم في تأهيل الجيل القادم من الكفاءات الوطنية. نحن نوفر لك الكوادر، وأنت
                تمنحهم الخبرة.
            </p>
        </div>
        <button
            class="relative z-10 bg-background-dark text-white px-10 py-5 rounded-2xl font-bold flex items-center gap-3 hover:bg-black transition-all transform hover:scale-105 shadow-xl whitespace-nowrap">
            <span class="material-symbols-outlined">business_center</span>
            سجل كشريك جديد
        </button>
    </section>
</main>
@endsection
