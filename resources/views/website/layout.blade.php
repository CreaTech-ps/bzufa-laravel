<!DOCTYPE html>
<html class="dark" dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $seo = $seo ?? \App\Models\SeoSetting::get();
        $siteTitle = $seo->site_title_ar ?? 'جمعية أصدقاء جامعة بيرزيت';
    @endphp
    <title>@hasSection('title')@yield('title') — {{ $siteTitle }}@else{{ $siteTitle }}@endif</title>
    @if(!empty($seo->meta_description_ar))
        <meta name="description" content="{{ Str::limit(strip_tags($seo->meta_description_ar), 160) }}">
    @endif
    @if(!empty($seo->meta_keywords_ar))
        <meta name="keywords" content="{{ strip_tags($seo->meta_keywords_ar) }}">
    @endif
    @if(isset($seo->allow_indexing) && !$seo->allow_indexing)
        <meta name="robots" content="noindex, nofollow">
    @endif
    {{-- Open Graph --}}
    <meta property="og:type" content="{{ $seo->og_type ?? 'website' }}">
    <meta property="og:title" content="{{ $seo->og_title_ar ?? $siteTitle }}">
    @if(!empty($seo->og_description_ar))
        <meta property="og:description" content="{{ Str::limit(strip_tags($seo->og_description_ar), 200) }}">
    @endif
    @if(!empty($seo->og_image_path))
        <meta property="og:image" content="{{ asset('storage/' . $seo->og_image_path) }}">
    @endif
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="ar_AR">
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="{{ $seo->twitter_card_type ?? 'summary_large_image' }}">
    @if(!empty($seo->twitter_site))
        <meta name="twitter:site" content="{{ $seo->twitter_site }}">
    @endif
    {{-- Google / Bing verification --}}
    @if(!empty($seo->google_site_verification))
        <meta name="google-site-verification" content="{{ $seo->google_site_verification }}">
    @endif
    @if(!empty($seo->bing_verification))
        <meta name="msvalidate.01" content="{{ $seo->bing_verification }}">
    @endif
    @if(!empty($seo->custom_meta_tags))
        {!! $seo->custom_meta_tags !!}
    @endif
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
     <!-- scripts -->

     <script src="{{ asset('assets/js/script.js') }}" defer></script>
    <script src="{{ asset('assets/js/navbar.js') }}" defer></script>
    <script src="{{ asset('assets/js/footer.js') }}" defer></script>
    @if(!empty($seo->google_analytics_id))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $seo->google_analytics_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $seo->google_analytics_id }}');
        </script>
    @endif
    @if(!empty($seo->organization_schema))
        <script type="application/ld+json">{!! $seo->organization_schema !!}</script>
    @endif
    @yield('styles')

</head>

<body
    class="bg-background-light dark:bg-background-dark text-slate-800 dark:text-text-primary-dark transition-colors duration-300">
    <main-navbar></main-navbar>
    <main>
        @yield('content')
    </main>
    <main-footer></main-footer>
    <button
        class="fixed bottom-6 left-6 w-12 h-12 bg-white dark:bg-card-dark border border-slate-200 dark:border-white/10 rounded-full shadow-2xl flex items-center justify-center z-50 hover:scale-110 transition-all"
        id="theme-toggle" onclick="toggleDarkMode()">
        <span class="material-symbols-outlined dark:hidden" id="theme-toggle-dark-icon">dark_mode</span>
        <span class="material-symbols-outlined hidden dark:block text-yellow-400"
            id="theme-toggle-light-icon">light_mode</span>
    </button>


   


    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;
        themeToggleBtn.addEventListener('click', function() {
            htmlElement.classList.toggle('dark');
            if (htmlElement.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        });
        // Check for saved theme preference
        if (localStorage.getItem('theme') === 'light') {
            htmlElement.classList.remove('dark');
        } else {
            htmlElement.classList.add('dark');
        }
    </script>

    @yield('scripts')
</body>

</html>