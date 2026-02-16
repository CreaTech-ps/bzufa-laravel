@extends('website.layout')
@section('title', 'شركاء النجاح')

@section('content')
        <section class="relative py-28 hero-gradient-sucess-partner overflow-hidden">
            <div class="max-w-5xl mx-auto px-6 md:px-12 lg:px-20 text-center relative z-10">
                <h1
                    class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-8 leading-tight text-slate-900 dark:text-white">
                    شركاء النجاح في مسيرتنا</h1>
                <p class="text-xl text-slate-700 dark:text-slate-300 mb-12 leading-relaxed max-w-2xl mx-auto">نعتز بنخبة
                    من الأفراد والمؤسسات الذين جعلوا مهمتنا ممكنة. دعمكم يغير الحياة ويخلق فرصاً جديدة للمستقبل.</p>
                <button
                    class="bg-primary hover:scale-105 active:scale-95 transition-transform text-white px-10 py-4 rounded-full font-bold text-lg shadow-lg shadow-primary/20">
                    كن شريكاً معنا
                </button>
            </div>
        </section>
        <section class="relative z-20 -mt-16">
            <div class="max-w-5xl mx-auto px-6 md:px-12 lg:px-20">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div
                        class="bg-white dark:bg-card-dark p-10 rounded-2xl shadow-xl dark:shadow-2xl border border-slate-100 dark:border-white/5 flex flex-col items-center">
                        <span class="text-primary text-4xl font-black mb-2">+{{ $totalPartners }}</span>
                        <span class="text-slate-500 dark:text-slate-400 font-medium">إجمالي الشركاء</span>
                        <div
                            class="mt-4 flex items-center text-green-600 dark:text-green-500 text-sm bg-green-500/10 px-3 py-1 rounded-full">
                            <span class="material-symbols-outlined text-sm ml-1">trending_up</span>
                            <span>15% نمو</span>
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-card-dark p-10 rounded-2xl shadow-xl dark:shadow-2xl border border-slate-100 dark:border-white/5 flex flex-col items-center">
                        <span class="text-primary text-4xl font-black mb-2">1.2M</span>
                        <span class="text-slate-500 dark:text-slate-400 font-medium">طلاب مستفيدون</span>
                        <div
                            class="mt-4 flex items-center text-green-600 dark:text-green-500 text-sm bg-green-500/10 px-3 py-1 rounded-full">
                            <span class="material-symbols-outlined text-sm ml-1">trending_up</span>
                            <span>22% زيادة</span>
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-card-dark p-10 rounded-2xl shadow-xl dark:shadow-2xl border border-slate-100 dark:border-white/5 flex flex-col items-center">
                        <span class="text-primary text-4xl font-black mb-2">85</span>
                        <span class="text-slate-500 dark:text-slate-400 font-medium">مشاريع ممولة</span>
                        <div
                            class="mt-4 flex items-center text-green-600 dark:text-green-500 text-sm bg-green-500/10 px-3 py-1 rounded-full">
                            <span class="material-symbols-outlined text-sm ml-1">trending_up</span>
                            <span>10% سنوي</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-24 bg-white dark:bg-transparent transition-colors duration-300">
            <div class="max-w-5xl mx-auto px-6 md:px-12 lg:px-20">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-16 gap-8">
                    <div>
                        <h2
                            class="text-3xl font-bold border-r-4 border-primary pr-4 mb-2 text-slate-900 dark:text-white">
                            شركاء التغيير</h2>
                        <p class="text-slate-500 dark:text-slate-400 text-sm mr-4">المؤسسات والشركات الداعمة لمسيرة
                            التعليم</p>
                    </div>
                    <div
                        class="bg-slate-100 dark:bg-card-dark p-1.5 rounded-full flex border border-slate-200 dark:border-white/5 transition-colors duration-300">
                        <button type="button" data-partner-filter="company"
                            class="partners-filter-btn px-8 py-2.5 rounded-full {{ ($type ?? 'company') === 'company' ? 'bg-primary text-white font-bold' : 'text-slate-500 dark:text-slate-400 hover:text-primary' }} shadow-md transition-all text-sm">شركاء
                            الشركات</button>
                        <button type="button" data-partner-filter="individual"
                            class="partners-filter-btn px-8 py-2.5 rounded-full {{ ($type ?? 'company') === 'individual' ? 'bg-primary text-white font-bold' : 'text-slate-500 dark:text-slate-400 hover:text-primary' }} transition-all text-sm">الداعمون
                            الأفراد</button>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="partners-grid">
                    @forelse($partners as $partner)
                    <div class="partner-card transition-opacity duration-300" data-type="{{ $partner->type }}">
                    @if($partner->link)
                    <a href="{{ $partner->link }}" target="_blank" rel="noopener"
                        class="group bg-white dark:bg-card-dark p-10 rounded-2xl border border-slate-100 dark:border-white/5 hover:border-primary/50 transition-all duration-300 flex flex-col items-center text-center shadow-sm hover:shadow-lg block h-full">
                    @else
                    <div
                        class="group bg-white dark:bg-card-dark p-10 rounded-2xl border border-slate-100 dark:border-white/5 hover:border-primary/50 transition-all duration-300 flex flex-col items-center text-center shadow-sm hover:shadow-lg cursor-default h-full">
                    @endif
                        <div
                            class="w-24 h-24 mb-6 grayscale group-hover:grayscale-0 transition-all duration-300 flex items-center justify-center opacity-80 group-hover:opacity-100">
                            <img alt="{{ $partner->name_ar }}" class="max-w-full h-auto object-contain"
                                src="{{ $partner->logo_path ? asset('storage/' . $partner->logo_path) : asset('assets/img/logo-l.svg') }}" />
                        </div>
                        <h3
                            class="font-bold text-lg group-hover:text-primary transition-colors text-slate-900 dark:text-white">
                            {{ $partner->name_ar }}</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-500 mt-2">{{ $partner->type === 'company' ? 'شركة / مؤسسة' : 'داعم فرد' }}</p>
                    @if($partner->link)
                    </a>
                    @else
                    </div>
                    @endif
                    </div>
                    @empty
                    <div class="col-span-full text-center py-16 text-slate-500 dark:text-slate-400">
                        لا يوجد شركاء حالياً
                    </div>
                    @endforelse
                </div>
                <div id="partners-empty-msg" class="hidden text-center py-16 text-slate-500 dark:text-slate-400 col-span-full">
                    لا يوجد شركاء في هذه الفئة حالياً
                </div>
            </div>
        </section>
        <section class="bg-slate-50 dark:bg-[#1a1a1a] py-24 transition-colors duration-300">
            <div class="max-w-5xl mx-auto px-6 md:px-12 lg:px-20">
                <div
                    class="max-w-4xl mx-auto bg-white dark:bg-card-dark p-14 rounded-[2.5rem] shadow-xl dark:shadow-2xl border border-slate-100 dark:border-white/5 text-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 blur-3xl rounded-full -mr-16 -mt-16">
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-6 text-slate-900 dark:text-white">هل تود أن تكون
                        جزءاً من رحلتنا؟</h2>
                    <p class="text-lg text-slate-600 dark:text-slate-400 mb-12 max-w-2xl mx-auto leading-relaxed">نحن
                        نؤمن بأن القوة في الاتحاد. انضم إلى شبكة شركائنا اليوم وساهم في رسم الابتسامة على وجوه الآلاف.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                        <button
                            class="w-full sm:w-auto bg-primary hover:bg-opacity-90 text-white px-12 py-4 rounded-full font-bold text-lg transition-all shadow-lg shadow-primary/30">
                            قدم طلب الشراكة
                        </button>
                        <button
                            class="w-full sm:w-auto border-2 border-primary/40 text-primary hover:bg-primary hover:text-white hover:border-primary px-12 py-4 rounded-full font-bold text-lg transition-all">
                            تحدث مع فريقنا
                        </button>
                    </div>
                </div>
            </div>
        </section>
@endsection

@section('scripts')
<script>
(function() {
    var grid = document.getElementById('partners-grid');
    var emptyMsg = document.getElementById('partners-empty-msg');
    var cards = grid ? grid.querySelectorAll('.partner-card') : [];
    var btns = document.querySelectorAll('.partners-filter-btn');
    var currentFilter = '{{ $type ?? "company" }}';

    function setActiveBtn(type) {
        btns.forEach(function(btn) {
            var t = btn.getAttribute('data-partner-filter');
            if (t === type) {
                btn.classList.add('bg-primary', 'text-white', 'font-bold');
                btn.classList.remove('text-slate-500', 'dark:text-slate-400');
            } else {
                btn.classList.remove('bg-primary', 'text-white', 'font-bold');
                btn.classList.add('text-slate-500', 'dark:text-slate-400');
            }
        });
    }

    function filterPartners(type) {
        currentFilter = type;
        setActiveBtn(type);
        var visible = 0;
        cards.forEach(function(card) {
            var show = card.getAttribute('data-type') === type;
            card.style.display = show ? '' : 'none';
            card.style.opacity = show ? '1' : '0';
            if (show) visible++;
        });
        if (emptyMsg) {
            emptyMsg.classList.toggle('hidden', visible > 0);
            if (visible === 0 && grid) {
                emptyMsg.classList.remove('hidden');
                grid.appendChild(emptyMsg);
            }
        }
    }

    btns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            filterPartners(btn.getAttribute('data-partner-filter'));
        });
    });
    setActiveBtn(currentFilter);
    filterPartners(currentFilter);
})();
</script>
@endsection