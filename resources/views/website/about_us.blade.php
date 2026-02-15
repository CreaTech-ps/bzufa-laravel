@extends('website.layout')

@section('title', 'من نحن')

@section('content')
<div class="max-w-6xl mx-auto px-8 lg:px-16 py-16 space-y-28">
        <section class="space-y-10">
            <div class="max-w-2xl">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">قصة الجمعية</h2>
                <p class="text-gray-600 dark:text-text-secondary text-lg leading-relaxed">
                    رحلة من العطاء بدأت بفكرة، ونمت بسواعد المخلصين لتغير حياة الآلاف. نحن نؤمن أن التعليم هو حق للجميع،
                    ومن هنا انطلقت رؤيتنا لتمكين طلبة جامعة بيرزيت وتوفير الفرص التي يستحقونها.
                </p>
            </div>
            <div
                class="relative rounded-[32px] overflow-hidden aspect-video bg-black shadow-2xl group border border-gray-200 dark:border-white/5">
                <img alt="Students working together"
                    class="w-full h-full object-cover opacity-70 dark:opacity-50 group-hover:scale-105 transition-transform duration-1000"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDe_U2g2RKthf6bg7nsaHl03IYlCYNKMqNGc6mYzqwbhjCEaop6Adw_KAL77i-bqGwUaq2iZo8oI37R-keedDS1qWj4h7bjxIrZdeKrAOonw-fiUkxT5GWbNwyPKE_HxW0evyw51IAFgC1t2nL_bMiRoSWStjagBGkBp7wjJkiKok0b17rAx1PwK80YD0e2CesrMvX1Deq34pr5Ke5BtB_PeqFhUVcgzdh1q4qcBWNtXt1Vn3dYkHlNsZUiqxW3wBj31t6gm0WapZQ" />
                <div class="absolute inset-0 flex items-center justify-center">
                    @if($aboutPage->story_video_url)
                    <a href="{{ $aboutPage->story_video_url }}" target="_blank" rel="noopener"
                        class="w-24 h-24 bg-primary text-white rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-6xl">play_arrow</span>
                    </a>
                    @else
                    <div class="w-24 h-24 bg-primary text-white rounded-full flex items-center justify-center shadow-2xl cursor-default">
                        <span class="material-symbols-outlined text-6xl">play_arrow</span>
                    </div>
                    @endif
                </div>
                @if($aboutPage->story_video_url)
                <div class="absolute bottom-0 inset-x-0 p-8 video-overlay">
                    <div class="flex items-center gap-6 text-white">
                        <span class="text-sm font-medium">شاهد رحلتنا</span>
                    </div>
                </div>
                @endif
            </div>
        </section>
        <section class="space-y-14">
            <div class="max-w-2xl">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-1.5 h-10 bg-primary rounded-full"></div>
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white">هويتنا وقيمنا</h2>
                </div>
                <p class="text-gray-600 dark:text-text-secondary text-lg leading-relaxed">
                    نحن نؤمن بأن العمل المؤسسي المنظم هو الطريق الأقصر لتحقيق الأثر المستدام.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @php $sectionIcons = ['vision' => 'visibility', 'mission' => 'auto_awesome', 'goals' => 'flag', 'values' => 'favorite']; @endphp
                @foreach($sections as $section)
                <div onclick="openLightbox(this.dataset.title, this.dataset.content, this.dataset.icon)"
                    data-title="{{ $section->title_ar }}" data-content="{{ e($section->content_ar ?: $section->title_ar) }}"
                    data-icon="{{ $sectionIcons[$section->type] ?? 'article' }}"
                    class="p-10 rounded-[28px] bg-white dark:bg-card-dark border border-gray-100 dark:border-white/10 hover:border-primary/40 transition-all duration-300 group shadow-sm cursor-pointer hover:-translate-y-2">
                    <div class="flex items-center gap-5 mb-8">
                        <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all duration-300">
                            <span class="material-symbols-outlined text-3xl">{{ $sectionIcons[$section->type] ?? 'article' }}</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $section->title_ar }}</h3>
                    </div>
                    <p class="text-gray-600 dark:text-text-secondary leading-loose text-lg">{{ Str::limit($section->content_ar ?: $section->title_ar, 150) }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <div id="lightbox"
            class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/60 backdrop-blur-md transition-all duration-300 opacity-0">

            <div class="bg-white dark:bg-card-dark w-[90%] max-w-xl rounded-[32px] p-6 sm:p-10 relative shadow-2xl scale-95 transition-transform duration-300 flex flex-col max-h-[85vh]"
                id="lightbox-content">

                <button onclick="closeLightbox()"
                    class="absolute top-4 left-4 text-gray-400 hover:text-primary transition-colors z-20">
                    <span class="material-symbols-outlined text-3xl">close</span>
                </button>

                <div class="overflow-y-auto pr-2 custom-scrollbar text-center mt-4">
                    <div id="lightbox-icon-container"
                        class="w-16 h-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-6 shrink-0">
                        <span id="lightbox-icon" class="material-symbols-outlined text-4xl"></span>
                    </div>

                    <h3 id="lightbox-title" class="text-2xl font-bold text-gray-900 dark:text-white mb-4"></h3>

                    <div id="lightbox-text"
                        class="text-gray-600 dark:text-text-secondary text-lg leading-relaxed text-justify px-2 pb-4">
                    </div>
                </div>
            </div>
        </div>
        <section
            class="relative rounded-[48px] overflow-hidden cta-gradient border border-primary/20 p-16 lg:p-24 text-center">
            <div class="absolute -top-32 -right-32 w-80 h-80 bg-primary/10 rounded-full blur-[100px]"></div>
            <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-primary/5 rounded-full blur-[100px]"></div>
            <div class="relative z-10 space-y-10 max-w-4xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-extrabold text-white leading-tight">
                    كن جزءاً من رحلتنا في العطاء
                </h2>
                <p class="text-xl text-gray-300 dark:text-text-secondary max-w-2xl mx-auto">
                    انضم إلينا اليوم وساهم في تغيير حياة الكثيرين للأفضل. تبرعك أو تطوعك يصنع الفرق الحقيقي.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-6 pt-6">
                    <button
                        class="w-full sm:w-auto px-12 py-5 bg-primary hover:bg-emerald-700 text-white font-bold rounded-2xl transition-all shadow-xl shadow-primary/30 text-lg">
                        انضم إلينا كمتطوع
                    </button>
                    <button
                        class="w-full sm:w-auto px-12 py-5 border-2 border-primary/50 text-primary hover:bg-primary hover:text-white font-bold rounded-2xl transition-all text-lg backdrop-blur-sm">
                        تبرع الآن
                    </button>
                </div>
            </div>
        </section>
</div>
@endsection

@section('scripts')
    <script>
        function openLightbox(title, text, icon) {
            const lightbox = document.getElementById('lightbox');
            const content = document.getElementById('lightbox-content');
            const scrollContainer = lightbox.querySelector('.overflow-y-auto');

            // 1. تعبئة البيانات
            document.getElementById('lightbox-title').innerText = title;
            document.getElementById('lightbox-text').innerText = text;
            document.getElementById('lightbox-icon').innerText = icon;

            // 2. إعادة تصفير السكرول داخل المودال لتبدأ القراءة من الأعلى
            if (scrollContainer) scrollContainer.scrollTop = 0;

            // 3. إظهار الـ Lightbox
            // نزيل hidden ونضيف flex فوراً لضمان تمدد الـ backdrop (inset-0) على كامل الشاشة
            lightbox.classList.remove('hidden');
            lightbox.classList.add('flex');

            // 4. تشغيل الانيميشن بعد لحظة بسيطة
            setTimeout(() => {
                lightbox.classList.add('opacity-100');
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);

            // 5. قفل سكرول الصفحة الرئيسية
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            const content = document.getElementById('lightbox-content');

            lightbox.classList.remove('opacity-100');
            content.classList.add('scale-100');

            setTimeout(() => {
                lightbox.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }

        // إغلاق عند النقر خارج المحتوى
        document.getElementById('lightbox').addEventListener('click', function (e) {
            if (e.target === this) closeLightbox();
        });
    </script>
@endsection