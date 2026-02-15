@extends('website.layout')
@section('title', 'المنح الدراسية')

@section('content')
<div class="max-w-6xl mx-auto px-8 lg:px-16 py-16 space-y-28">
    <section class="space-y-10">
        <div class="max-w-[1400px] mx-auto px-12 lg:px-20 mb-20">
            <div class="relative inline-block mb-6">
                <div class="absolute -right-6 top-1/2 -translate-y-1/2 w-2 h-16 bg-primary rounded-full"></div>
                <h1 class="text-4xl md:text-6xl font-black tracking-tight leading-tight">المنح الدراسية<br /><span
                        class="text-slate-400 dark:text-slate-500">المتاحة حالياً</span></h1>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-xl max-w-2xl leading-relaxed mt-4">نحن نؤمن بتمكين الجيل
                القادم. استكشف مجموعة متنوعة من فرص الدعم المالي المصممة لدعم تميزك الأكاديمي وتطلعاتك المهنية.</p>
        </div>
        <div class="max-w-[1400px] mx-auto px-12 lg:px-20 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 mb-24">
            @forelse($scholarships as $scholarship)
            @php
                $endDate = $scholarship->application_end_date;
                $daysLeft = $endDate ? now()->diffInDays($endDate, false) : null;
                $badgeClass = 'bg-primary/90';
                $badgeText = 'متاح للتقديم';
                if ($endDate && $daysLeft !== null) {
                    if ($daysLeft <= 0) {
                        $badgeClass = 'bg-red-500/90';
                        $badgeText = 'انتهى التقديم';
                    } elseif ($daysLeft <= 3) {
                        $badgeClass = 'bg-red-500/90';
                        $badgeText = 'ينتهي خلال ' . $daysLeft . ' أيام';
                    } elseif ($daysLeft <= 14) {
                        $badgeClass = 'bg-orange-500/90';
                        $badgeText = 'ينتهي قريباً';
                    } else {
                        $badgeText = 'ينتهي في ' . $endDate->translatedFormat('d F');
                        $badgeClass = 'bg-blue-500/90';
                    }
                }
            @endphp
            <a href="{{ route('grants.show', $scholarship->slug_ar ?: $scholarship->id) }}"
                class="scholarship-card {{ $loop->first ? 'bg-white dark:bg-card-dark/40 backdrop-blur-xl' : 'glass-card' }} rounded-[32px] overflow-hidden flex flex-col group border border-slate-200/60 dark:border-white/5 block">
                <div class="relative h-64 overflow-hidden">
                    <img alt="{{ $scholarship->title_ar }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        src="{{ $scholarship->image_path ? asset('storage/' . $scholarship->image_path) : asset('assets/img/logo-l.svg') }}" />
                    <div class="absolute inset-0 bg-gradient-to-t from-background-dark/60 to-transparent"></div>
                    @if($endDate)
                    <div
                        class="absolute top-5 right-5 {{ $badgeClass }} backdrop-blur-md text-white text-[11px] font-black px-4 py-2 rounded-full flex items-center gap-2 shadow-lg">
                        <span class="material-symbols-outlined text-sm">event</span> {{ $badgeText }}
                    </div>
                    @endif
                </div>
                <div class="p-10 flex flex-col flex-grow">
                    <div class="flex justify-between items-center mb-6">
                        <span
                            class="text-[10px] font-black text-primary uppercase tracking-widest bg-primary/10 px-4 py-1.5 rounded-full border border-primary/20">منحة
                            دراسية</span>
                        <div class="flex items-center gap-1.5 text-emerald-500 text-[10px] font-black uppercase">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> مفتوح
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 group-hover:text-primary transition-colors">{{ $scholarship->title_ar }}</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mb-8 leading-relaxed opacity-90">{{ Str::limit($scholarship->summary_ar, 120) }}</p>
                    <div class="mt-auto">
                        <div class="flex justify-between items-end mb-8">
                            <div>
                                <span
                                    class="text-[10px] font-bold text-slate-400 block mb-1 uppercase tracking-tighter">الموعد
                                    النهائي</span>
                                <span class="font-black text-primary text-2xl">{{ $endDate ? $endDate->translatedFormat('d/m/Y') : '—' }}</span>
                            </div>
                        </div>
                        <span
                            class="w-full primary-gradient-grants text-white font-black py-4 rounded-2xl flex items-center justify-center gap-3 btn-glow-grants transition-all duration-300 group/btn">
                            <span>تفاصيل التقديم</span>
                            <span
                                class="material-symbols-outlined text-lg transition-transform group-hover/btn:-translate-x-1">arrow_back</span>
                        </span>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-20 text-slate-500 dark:text-slate-400">
                لا توجد منح متاحة حالياً. تحقق لاحقاً.
            </div>
            @endforelse
        </div>
        @if($scholarships->hasPages())
        <div class="max-w-[1400px] mx-auto px-12 lg:px-20 flex justify-center items-center mb-32">
            {{ $scholarships->links('pagination::tailwind') }}
        </div>
        @endif
        <div class="max-w-[1400px] mx-auto px-12 lg:px-20">
            <div class="bg-[#151515] rounded-[48px] p-12 md:p-20 relative overflow-hidden border border-white/5">
                <div class="absolute -top-32 -left-32 w-[500px] h-[500px] bg-primary/10 rounded-full blur-[120px]">
                </div>
                <div class="absolute -bottom-32 -right-32 w-[400px] h-[400px] bg-primary/5 rounded-full blur-[100px]">
                </div>
                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <h2 class="text-4xl md:text-5xl font-black mb-8 text-white leading-tight">رؤيتنا
                            لمستقبل<br /><span class="text-primary">التعليم الفلسطيني</span></h2>
                        <p class="text-slate-400 text-lg leading-relaxed mb-10">
                            نحن لسنا مجرد مانحين؛ نحن شركاء في بناء الوطن. نسعى لسد الفجوة بين الطموح والواقع، موفرين
                            الموارد اللازمة لكل عقل مبدع في جامعة بيرزيت ليزدهر ويقود التغيير.
                        </p>
                        <div class="flex gap-4">
                            <button
                                class="bg-white/10 hover:bg-white/20 text-white px-8 py-4 rounded-2xl font-bold transition-all backdrop-blur-md border border-white/10">اقرأ
                                عن تأثيرنا</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div
                            class="bg-white/5 backdrop-blur-2xl border border-white/10 p-10 rounded-[40px] relative group overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-bl-full translate-x-8 -translate-y-8 group-hover:translate-x-4 group-hover:-translate-y-4 transition-transform">
                            </div>
                            <span class="material-symbols-outlined text-primary text-4xl mb-4">monetization_on</span>
                            <div class="text-5xl font-black text-white mb-2">2.5M</div>
                            <div class="text-[10px] text-slate-400 uppercase tracking-[0.2em] font-black">إجمالي الدعم
                                السنوي ($)</div>
                        </div>
                        <div
                            class="bg-white/5 backdrop-blur-2xl border border-white/10 p-10 rounded-[40px] relative group overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-bl-full translate-x-8 -translate-y-8 group-hover:translate-x-4 group-hover:-translate-y-4 transition-transform">
                            </div>
                            <span class="material-symbols-outlined text-primary text-4xl mb-4">groups</span>
                            <div class="text-5xl font-black text-white mb-2">{{ $totalActive ?? 0 }}+</div>
                            <div class="text-[10px] text-slate-400 uppercase tracking-[0.2em] font-black">منحة دراسية
                                مفعلة</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection