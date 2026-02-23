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
                        {{-- لوحة التحكم --}}
                        <li>
                            <a href="{{ route('cp.dashboard') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary dark:hover:text-primary transition-colors {{ request()->routeIs('cp.dashboard') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                <span class="material-symbols-outlined text-xl">dashboard</span>
                                <span>لوحة التحكم</span>
                            </a>
                        </li>
                        @if(cpCan('home'))
                        {{-- الصفحة الرئيسية --}}
                        <li class="cp-nav-section pt-2 mt-2 {{ request()->routeIs('cp.home.*', 'cp.home-statistics.*', 'cp.home-projects.*') ? '' : 'cp-collapsed' }}" data-section="home">
                            <button type="button" class="cp-section-toggle" aria-expanded="{{ request()->routeIs('cp.home.*', 'cp.home-statistics.*', 'cp.home-projects.*') ? 'true' : 'false' }}">
                                <span>الصفحة الرئيسية</span>
                                <span class="material-symbols-outlined cp-chevron">expand_more</span>
                            </button>
                            <ul class="cp-section-content space-y-0.5">
                                <li>
                                    <a href="{{ route('cp.home.edit') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.home.*') || request()->routeIs('cp.home-statistics.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
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
                            </ul>
                        </li>
                        @endif
                        @if(cpCan('kanani') || cpCan('tamkeen') || cpCan('parasols'))
                        {{-- المشاريع --}}
                        <li class="cp-nav-section pt-2 mt-2 {{ request()->routeIs('cp.kanani.*', 'cp.tamkeen.*', 'cp.parasols.*') ? '' : 'cp-collapsed' }}" data-section="projects">
                            <button type="button" class="cp-section-toggle" aria-expanded="{{ request()->routeIs('cp.kanani.*', 'cp.tamkeen.*', 'cp.parasols.*') ? 'true' : 'false' }}">
                                <span>المشاريع</span>
                                <span class="material-symbols-outlined cp-chevron">expand_more</span>
                            </button>
                            <ul class="cp-section-content space-y-0.5">
                                @if(cpCan('kanani'))
                                <li>
                                    <a href="{{ route('cp.kanani.edit') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.kanani.edit') || request()->routeIs('cp.kanani.gallery.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                        <span class="material-symbols-outlined text-xl">storefront</span>
                                        <span>كنعاني</span>
                                    </a>
                                </li>
                                @endif
                                @if(cpCan('tamkeen'))
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
                                @endif
                                @if(cpCan('parasols'))
                                <li>
                                    <a href="{{ route('cp.parasols.edit') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.parasols.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                        <span class="material-symbols-outlined text-xl">filter_drama</span>
                                        <span>المظلات</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(cpCan('scholarships') || cpCan('partners'))
                        {{-- المنح والشراكات --}}
                        <li class="cp-nav-section pt-2 mt-2 {{ request()->routeIs('cp.scholarships.*', 'cp.partners.*') ? '' : 'cp-collapsed' }}" data-section="grants">
                            <button type="button" class="cp-section-toggle" aria-expanded="{{ request()->routeIs('cp.scholarships.*', 'cp.partners.*') ? 'true' : 'false' }}">
                                <span>المنح والشراكات</span>
                                <span class="material-symbols-outlined cp-chevron">expand_more</span>
                            </button>
                            <ul class="cp-section-content space-y-0.5">
                                @if(cpCan('scholarships'))
                                <li>
                                    <a href="{{ route('cp.scholarships.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.scholarships.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                        <span class="material-symbols-outlined text-xl">school</span>
                                        <span>المنح الجامعية</span>
                                    </a>
                                </li>
                                @endif
                                @if(cpCan('partners'))
                                <li>
                                    <a href="{{ route('cp.partners.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.partners.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                        <span class="material-symbols-outlined text-xl">handshake</span>
                                        <span>شركاء النجاح</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(cpCan('newsletter'))
                        {{-- النشرة الإخبارية --}}
                        <li class="cp-nav-section pt-2 mt-2 {{ request()->routeIs('cp.newsletter.index', 'cp.newsletter.broadcast') ? '' : 'cp-collapsed' }}" data-section="newsletter">
                            <button type="button" class="cp-section-toggle" aria-expanded="{{ request()->routeIs('cp.newsletter.index', 'cp.newsletter.broadcast') ? 'true' : 'false' }}">
                                <span>النشرة الإخبارية</span>
                                <span class="material-symbols-outlined cp-chevron">expand_more</span>
                            </button>
                            <ul class="cp-section-content space-y-0.5">
                                <li>
                                    <a href="{{ route('cp.newsletter.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.newsletter.index') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                        <span class="material-symbols-outlined text-xl">mail</span>
                                        <span>المشتركون</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('cp.newsletter.broadcast') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.newsletter.broadcast') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                        <span class="material-symbols-outlined text-xl">campaign</span>
                                        <span>إرسال رسالة جماعية</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if(cpCan('about'))
                        {{-- صفحات ثابتة --}}
                        <li class="cp-nav-section pt-2 mt-2 {{ request()->routeIs('cp.about.*', 'cp.team-members.*') ? '' : 'cp-collapsed' }}" data-section="about">
                            <button type="button" class="cp-section-toggle" aria-expanded="{{ request()->routeIs('cp.about.*', 'cp.team-members.*') ? 'true' : 'false' }}">
                                <span>صفحات ثابتة</span>
                                <span class="material-symbols-outlined cp-chevron">expand_more</span>
                            </button>
                            <ul class="cp-section-content space-y-0.5">
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
                            </ul>
                        </li>
                        @endif
                        @if(cpCan('content'))
                        {{-- المحتوى الديناميكي --}}
                        <li class="cp-nav-section pt-2 mt-2 {{ request()->routeIs('cp.news.*', 'cp.success-stories.*') ? '' : 'cp-collapsed' }}" data-section="content">
                            <button type="button" class="cp-section-toggle" aria-expanded="{{ request()->routeIs('cp.news.*', 'cp.success-stories.*') ? 'true' : 'false' }}">
                                <span>المحتوى</span>
                                <span class="material-symbols-outlined cp-chevron">expand_more</span>
                            </button>
                            <ul class="cp-section-content space-y-0.5">
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
                            </ul>
                        </li>
                        {{-- الطلبات والنماذج --}}
                        <li class="cp-nav-section pt-2 mt-2 {{ request()->routeIs('cp.scholarship-applications.*', 'cp.volunteer-departments.*', 'cp.volunteer-applications.*', 'cp.tamkeen.partnership-requests.*', 'cp.partnership-requests.*') ? '' : 'cp-collapsed' }}" data-section="applications">
                            <button type="button" class="cp-section-toggle" aria-expanded="{{ request()->routeIs('cp.scholarship-applications.*', 'cp.volunteer-departments.*', 'cp.volunteer-applications.*', 'cp.tamkeen.partnership-requests.*', 'cp.partnership-requests.*') ? 'true' : 'false' }}">
                                <span>الطلبات والنماذج</span>
                                <span class="material-symbols-outlined cp-chevron">expand_more</span>
                            </button>
                            <ul class="cp-section-content space-y-0.5">
                                <li>
                                    <a href="{{ route('cp.scholarship-applications.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.scholarship-applications.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                        <span class="material-symbols-outlined text-xl">description</span>
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
                        </li>
                        @endif
                        @if(cpCan('financial'))
                        {{-- المالية والتبرعات --}}
                        <li class="cp-nav-section pt-2 mt-2 {{ request()->routeIs('cp.financial.index', 'cp.donations.*', 'cp.financial-transactions.*', 'cp.financial.reports.*') ? '' : 'cp-collapsed' }}" data-section="financial">
                            <button type="button" class="cp-section-toggle" aria-expanded="{{ request()->routeIs('cp.financial.index', 'cp.donations.*', 'cp.financial-transactions.*', 'cp.financial.reports.*') ? 'true' : 'false' }}">
                                <span>المالية والتبرعات</span>
                                <span class="material-symbols-outlined cp-chevron">expand_more</span>
                            </button>
                            <ul class="cp-section-content space-y-0.5">
                                <li>
                                    <a href="{{ route('cp.financial.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.financial.index') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                        <span class="material-symbols-outlined text-xl">account_balance</span>
                                        <span>لوحة المالية</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('cp.donations.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.donations.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                        <span class="material-symbols-outlined text-xl">volunteer_activism</span>
                                        <span>التبرعات</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('cp.financial-transactions.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.financial-transactions.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                        <span class="material-symbols-outlined text-xl">payments</span>
                                        <span>الحركات المالية</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('cp.financial.reports.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.financial.reports.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                        <span class="material-symbols-outlined text-xl">assessment</span>
                                        <span>التقارير والإحصائيات</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if(cpCan('settings'))
                        {{-- إعدادات الموقع --}}
                        <li class="cp-nav-section pt-2 mt-2 {{ request()->routeIs('cp.site-settings.*', 'cp.seo-settings.*', 'cp.site-texts.*') ? '' : 'cp-collapsed' }}" data-section="settings">
                            <button type="button" class="cp-section-toggle" aria-expanded="{{ request()->routeIs('cp.site-settings.*', 'cp.seo-settings.*', 'cp.site-texts.*') ? 'true' : 'false' }}">
                                <span>إعدادات الموقع</span>
                                <span class="material-symbols-outlined cp-chevron">expand_more</span>
                            </button>
                            <ul class="cp-section-content space-y-0.5">
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
                            </ul>
                        </li>
                        @endif
                        @if(cpCan('users'))
                        {{-- المستخدمون والصلاحيات --}}
                        <li class="cp-nav-section pt-2 mt-2 {{ request()->routeIs('cp.users.*', 'cp.roles.*') ? '' : 'cp-collapsed' }}" data-section="system">
                            <button type="button" class="cp-section-toggle" aria-expanded="{{ request()->routeIs('cp.users.*', 'cp.roles.*') ? 'true' : 'false' }}">
                                <span>النظام</span>
                                <span class="material-symbols-outlined cp-chevron">expand_more</span>
                            </button>
                            <ul class="cp-section-content space-y-0.5">
                                <li>
                                    <a href="{{ route('cp.users.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.users.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                        <span class="material-symbols-outlined text-xl">people</span>
                                        <span>المستخدمون</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('cp.roles.index') }}" class="cp-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-colors {{ request()->routeIs('cp.roles.*') ? 'bg-primary/10 text-primary dark:bg-primary/20' : '' }}">
                                        <span class="material-symbols-outlined text-xl">admin_panel_settings</span>
                                        <span>الأدوار والصلاحيات</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
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
                    <span class="text-sm text-slate-500 dark:text-slate-400 hidden sm:inline">{{ auth()->user()->name ?? '' }}</span>
                    <form action="{{ route('cp.logout') }}" method="post" class="inline">
                        @csrf
                        <button type="submit" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors" title="تسجيل الخروج" aria-label="تسجيل الخروج">
                            <span class="material-symbols-outlined text-xl">logout</span>
                        </button>
                    </form>
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
            const openBtn = document.getElementById('cp-sidebar-open');
            const closeBtn = document.getElementById('cp-sidebar-close');
            const themeToggle = document.getElementById('cp-theme-toggle');

            function openSidebar() {
                sidebar.classList.remove('translate-x-full');
                sidebar.classList.add('translate-x-0');
                document.body.classList.add('overflow-hidden');
            }
            function closeSidebar() {
                if (window.innerWidth < 1024) {
                    sidebar.classList.add('translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                }
                document.body.classList.remove('overflow-hidden');
            }

            openBtn?.addEventListener('click', openSidebar);
            closeBtn?.addEventListener('click', closeSidebar);

            themeToggle?.addEventListener('click', function() {
                document.documentElement.classList.toggle('dark');
                localStorage.setItem('cp-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
            });

            if (localStorage.getItem('cp-theme') === 'dark') document.documentElement.classList.add('dark');
            else if (localStorage.getItem('cp-theme') === 'light') document.documentElement.classList.remove('dark');

            if (window.innerWidth < 1024) { sidebar?.classList.add('translate-x-full'); sidebar?.classList.remove('translate-x-0'); }

            /* أقسام القائمة القابلة للطي */
            const STORAGE_KEY = 'cp-nav-sections';
            document.querySelectorAll('.cp-section-toggle').forEach(function(btn) {
                var section = btn.closest('.cp-nav-section');
                if (!section) return;
                var id = section.getAttribute('data-section');
                var saved = null;
                try { saved = JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}'); } catch(e) {}
                if (saved && typeof saved[id] === 'boolean') {
                    if (saved[id]) {
                        section.classList.remove('cp-collapsed');
                        btn.setAttribute('aria-expanded', 'true');
                    } else {
                        section.classList.add('cp-collapsed');
                        btn.setAttribute('aria-expanded', 'false');
                    }
                }
                btn.addEventListener('click', function() {
                    var collapsed = section.classList.toggle('cp-collapsed');
                    btn.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
                    try {
                        var o = JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}');
                        o[id] = !collapsed;
                        localStorage.setItem(STORAGE_KEY, JSON.stringify(o));
                    } catch(e) {}
                });
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
