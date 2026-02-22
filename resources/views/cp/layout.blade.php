<!DOCTYPE html>
<html class="cp-admin" dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم') — جمعية أصدقاء جامعة بيرزيت</title>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Tajawal', 'sans-serif'] },
                    colors: {
                        primary: '#08A46D',
                        'primary-dark': '#069660',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="{{ asset('assets/css/cp.css') }}">
    @stack('styles')
</head>
<body class="font-sans bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 min-h-screen transition-colors duration-300">
    <div class="cp-wrap flex min-h-screen">
        {{-- Sidebar --}}
        <aside id="cp-sidebar" class="cp-sidebar fixed top-0 right-0 z-40 h-full w-64 bg-white dark:bg-slate-800 border-l border-slate-200 dark:border-slate-700 shadow-lg transform transition-transform duration-300 ease-out translate-x-full lg:translate-x-0 lg:static lg:shadow-none" aria-label="القائمة الجانبية">
            <div class="flex flex-col h-full">
                <div class="p-4 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <a href="{{ route('cp.dashboard') }}" class="flex items-center gap-2">
                        <img src="{{ asset('assets/img/logo-d.svg') }}" alt="جمعية أصدقاء جامعة بيرزيت" class="h-9 w-auto" />
                    </a>
                    <button type="button" id="cp-sidebar-close" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700" aria-label="إغلاق القائمة">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <nav class="flex-1 overflow-y-auto py-4 px-3">
                    <ul class="space-y-0.5">
                        <li>
                            <a href="{{ route('cp.dashboard') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary dark:hover:text-primary transition-colors {{ request()->routeIs('cp.dashboard') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">dashboard</span>
                                <span>لوحة التحكم</span>
                            </a>
                        </li>
                        <li class="pt-2 mt-2 border-t border-slate-200 dark:border-slate-700">
                            <p class="px-3 py-1.5 text-xs font-medium text-slate-400 dark:text-slate-500 uppercase tracking-wider">إعدادات الموقع</p>
                        </li>
                        <li>
                            <a href="{{ route('cp.site-settings.edit') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.site-settings.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">settings</span>
                                <span>إعدادات الموقع</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.seo-settings.edit') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.seo-settings.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">search</span>
                                <span>إعدادات SEO</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.site-texts.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.site-texts.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">text_fields</span>
                                <span>النصوص والمحتوى</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.home.edit') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.home.*') || request()->routeIs('cp.home-statistics.*') || request()->routeIs('cp.home-projects.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">home</span>
                                <span>الصفحة الرئيسية</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.home-projects.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.home-projects.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">work</span>
                                <span>بطاقات المشاريع</span>
                            </a>
                        </li>
                        <li class="pt-2 mt-2 border-t border-slate-200 dark:border-slate-700">
                            <p class="px-3 py-1.5 text-xs font-medium text-slate-400 dark:text-slate-500 uppercase tracking-wider">المحتوى</p>
                        </li>
                        <li>
                            <a href="{{ route('cp.about.edit') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.about.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">info</span>
                                <span>من نحن</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.team-members.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.team-members.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">groups</span>
                                <span>الفريق</span>
                            </a>
                        </li>
                        <li class="pt-2 mt-2 border-t border-slate-200 dark:border-slate-700">
                            <p class="px-3 py-1.5 text-xs font-medium text-slate-400 dark:text-slate-500 uppercase tracking-wider">المشاريع</p>
                        </li>
                        <li>
                            <a href="{{ route('cp.kanani.edit') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.kanani.edit') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">storefront</span>
                                <span>كنعاني</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.kanani.gallery.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.kanani.gallery.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">inventory_2</span>
                                <span>منتجات المتجر</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.tamkeen.partnerships.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.tamkeen.partnerships.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">handshake</span>
                                <span>شراكات تمكين</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.tamkeen.settings.edit') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.tamkeen.settings.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">category</span>
                                <span>قطاعات تمكين</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.parasols.edit') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.parasols.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">filter_drama</span>
                                <span>المظلات</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.scholarships.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.scholarships.*') || request()->routeIs('cp.scholarship-applications.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">school</span>
                                <span>المنح الجامعية</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.partners.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.partners.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">handshake</span>
                                <span>شركاء النجاح</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.news.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.news.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">newspaper</span>
                                <span>الأخبار</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.success-stories.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.success-stories.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">auto_stories</span>
                                <span>قصص النجاح</span>
                            </a>
                        </li>
                        <li class="pt-2 mt-2 border-t border-slate-200 dark:border-slate-700">
                            <p class="px-3 py-1.5 text-xs font-medium text-slate-400 dark:text-slate-500 uppercase tracking-wider">الطلبات والنماذج</p>
                        </li>
                        <li>
                            <a href="{{ route('cp.scholarship-applications.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.scholarship-applications.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">school</span>
                                <span>طلبات المنح</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.volunteer-departments.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.volunteer-departments.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">volunteer_activism</span>
                                <span>أقسام التطوع</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.volunteer-applications.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.volunteer-applications.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">person_add</span>
                                <span>طلبات التطوع</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.tamkeen.partnership-requests.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.tamkeen.partnership-requests.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">handshake</span>
                                <span>طلبات شراكة تمكين</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cp.partnership-requests.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.partnership-requests.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">handshake</span>
                                <span>طلبات شراكة شركاء النجاح</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="p-3 border-t border-slate-200 dark:border-slate-700">
                    <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors text-sm">
                        <span class="material-symbols-outlined text-lg">open_in_new</span>
                        <span>عرض الموقع</span>
                    </a>
                </div>
            </div>
        </aside>

        {{-- Overlay (mobile) --}}
        <div id="cp-sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 opacity-0 pointer-events-none transition-opacity lg:hidden" aria-hidden="true"></div>

        {{-- Main content --}}
        <div class="cp-main flex-1 flex flex-col min-w-0">
            <header class="cp-header sticky top-0 z-20 flex items-center justify-between gap-4 px-4 py-3 bg-white/80 dark:bg-slate-800/80 backdrop-blur border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <button type="button" id="cp-sidebar-open" class="lg:hidden p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700" aria-label="فتح القائمة">
                        <span class="material-symbols-outlined text-2xl">menu</span>
                    </button>
                    <h1 class="text-lg font-bold text-slate-800 dark:text-white truncate">@yield('title', 'لوحة التحكم')</h1>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" id="cp-theme-toggle" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors" aria-label="تبديل الوضع الليلي">
                        <span class="material-symbols-outlined dark:hidden">dark_mode</span>
                        <span class="material-symbols-outlined hidden dark:inline text-amber-400">light_mode</span>
                    </button>
                </div>
            </header>

            <main class="flex-1 p-4 lg:p-6">
                @if(session('success'))
                    <div class="mb-4 px-4 py-3 rounded-xl bg-primary/10 dark:bg-primary/20 text-primary border border-primary/20" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 px-4 py-3 rounded-xl bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/20" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        (function() {
            const sidebar = document.getElementById('cp-sidebar');
            const overlay = document.getElementById('cp-sidebar-overlay');
            const openBtn = document.getElementById('cp-sidebar-open');
            const closeBtn = document.getElementById('cp-sidebar-close');
            const themeToggle = document.getElementById('cp-theme-toggle');

            function openSidebar() {
                sidebar.classList.remove('translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('opacity-0', 'pointer-events-none');
                document.body.classList.add('overflow-hidden');
            }
            function closeSidebar() {
                if (window.innerWidth < 1024) {
                    sidebar.classList.add('translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                }
                overlay.classList.add('opacity-0', 'pointer-events-none');
                document.body.classList.remove('overflow-hidden');
            }

            openBtn?.addEventListener('click', openSidebar);
            closeBtn?.addEventListener('click', closeSidebar);
            overlay?.addEventListener('click', closeSidebar);

            themeToggle?.addEventListener('click', function() {
                document.documentElement.classList.toggle('dark');
                localStorage.setItem('cp-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
            });

            if (localStorage.getItem('cp-theme') === 'dark') document.documentElement.classList.add('dark');
            else if (localStorage.getItem('cp-theme') === 'light') document.documentElement.classList.remove('dark');

            if (window.innerWidth < 1024) { sidebar?.classList.add('translate-x-full'); sidebar?.classList.remove('translate-x-0'); }
        })();
    </script>
    @stack('scripts')
</body>
</html>
