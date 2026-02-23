@extends('website.layout')

@section('title', localized($news, 'title'))

@push('styles')
@if(!empty($news->image_path))
<meta property="og:image" content="{{ asset('storage/' . $news->image_path) }}" />
@endif
{{-- Quill output styles: المحتوى المُخزَن من المحرر يستخدم classes مثل ql-align-center, ql-indent-1 --}}
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
/* تغطية كاملة للصفحة من اليسار لليمين - إلغاء تنسيقات محرر Quill للحاوية */
.news-content.ql-editor { font-size: 1.125rem; line-height: 1.75; width: 100%; max-width: 100%; padding: 0; border: none; overflow-y: visible; min-height: auto; outline: none; }
.news-content.ql-editor p { margin-bottom: 1rem; }
.news-content.ql-editor h1, .news-content.ql-editor h2, .news-content.ql-editor h3, .news-content.ql-editor h4 { font-weight: 700; color: rgb(15 23 42); margin-top: 1.5rem; margin-bottom: 0.75rem; }
.dark .news-content.ql-editor h1, .dark .news-content.ql-editor h2, .dark .news-content.ql-editor h3, .dark .news-content.ql-editor h4 { color: #fff; }
.news-content.ql-editor blockquote { border-inline-start: 4px solid var(--primary, #0ba66d); background: rgba(11,166,109,0.08); padding: 0.75rem 1rem; margin: 1rem 0; border-radius: 0.75rem; font-style: italic; }
.dark .news-content.ql-editor blockquote { background: rgba(11,166,109,0.15); }
.news-content.ql-editor pre, .news-content.ql-editor .ql-syntax { background: rgb(241 245 249); padding: 1rem; border-radius: 0.75rem; overflow-x: auto; font-size: 0.875rem; margin: 1rem 0; }
.dark .news-content.ql-editor pre, .dark .news-content.ql-editor .ql-syntax { background: rgb(30 41 59); }
.news-content.ql-editor img { max-width: 100%; height: auto; border-radius: 0.75rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin: 1rem 0; }
.news-content.ql-editor a { color: var(--primary, #0ba66d); font-weight: 500; text-decoration: none; }
.news-content.ql-editor a:hover { text-decoration: underline; }
</style>
@endpush
    
@section('content')
<main class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-16 md:pb-20">
    {{-- Breadcrumb --}}
    <nav class="flex items-center text-xs gap-2 text-slate-500 dark:text-slate-400 mb-8">
        <a class="hover:text-primary transition-colors" href="{{ localized_route('home') }}">{{ __('ui.nav_home') }}</a>
        <span class="material-symbols-outlined text-[14px] rtl:rotate-180">chevron_left</span>
        <a class="hover:text-primary transition-colors" href="{{ localized_route('news.index') }}">{{ __('ui.news_archive_title') }}</a>
        <span class="material-symbols-outlined text-[14px] rtl:rotate-180">chevron_left</span>
        <span class="text-text-dark-gray dark:text-white font-semibold line-clamp-1">{{ localized($news, 'title') }}</span>
    </nav>

    {{-- Header --}}
    <div class="mb-10 text-center max-w-4xl mx-auto">
        <div class="flex items-center justify-center gap-3 mb-4 flex-wrap">
            <span class="text-slate-400 text-sm font-medium flex items-center gap-1">
                <span class="material-symbols-outlined text-base">calendar_month</span>
                {{ $news->published_at?->locale(app()->getLocale())->translatedFormat('d F Y') ?? '—' }}
            </span>
        </div>
        <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 dark:text-white mb-8 leading-tight">
            {{ localized($news, 'title') }}
        </h1>
        <div class="flex items-center justify-center">
            <button type="button" id="news-share-btn"
                class="w-10 h-10 rounded-full bg-slate-100 dark:bg-bg-dark-card flex items-center justify-center hover:bg-primary hover:text-white transition-all text-slate-500"
                title="{{ __('ui.share') }}">
                <span class="material-symbols-outlined text-lg">share</span>
            </button>
        </div>
        <script>
        document.getElementById('news-share-btn')?.addEventListener('click', function() {
            var url = window.location.href;
            var title = {{ json_encode(localized($news, 'title')) }};
            var text = {{ json_encode(Str::limit(strip_tags(localized($news, 'summary') ?? localized($news, 'title')), 100)) }};
            if (navigator.share) {
                navigator.share({ title: title, text: text, url: url }).catch(function() {
                    navigator.clipboard.writeText(url);
                });
            } else {
                navigator.clipboard.writeText(url);
            }
        });
        </script>
    </div>

    {{-- Featured Image --}}
    @if($news->image_path)
    <div
        class="w-full h-[300px] md:h-[500px] rounded-[2rem] overflow-hidden mb-12 border border-slate-200 dark:border-slate-800">
        <img alt="{{ localized($news, 'title') }}" class="w-full h-full object-cover"
            src="{{ asset('storage/' . $news->image_path) }}" loading="eager" width="1200" height="600" />
    </div>
    @endif

    {{-- Content: عرض المحتوى بعرض كامل داخل الحاوية --}}
    <article class="w-full">
        <div class="news-content ql-editor rich-text text-slate-700 dark:text-slate-300"
            @if(app()->getLocale() === 'ar') dir="rtl" @endif>
            @if(localized($news, 'content'))
                {!! localized($news, 'content') !!}
            @elseif(localized($news, 'summary'))
                <p class="text-lg leading-relaxed">{{ localized($news, 'summary') }}</p>
            @else
                <p class="text-lg leading-relaxed text-slate-500">{{ localized($news, 'title') }}</p>
            @endif
        </div>
    </article>

    {{-- Related News --}}
    @if($relatedNews->isNotEmpty())
    <section class="mt-20">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">{{ __('ui.related_news') }}</h2>
            <a class="text-primary font-bold text-sm flex items-center gap-1 hover:gap-2 transition-all"
                href="{{ localized_route('news.index') }}">
                {{ __('ui.all_news') }}
                <span class="material-symbols-outlined text-sm rtl:rotate-180">arrow_back</span>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($relatedNews as $item)
            <article
                class="bg-white dark:bg-bg-dark-card rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 hover:shadow-xl transition-all group flex flex-col">
                <a href="{{ localized_route('news.show', ['slug' => current_slug($item)]) }}">
                    <div class="relative h-44 overflow-hidden">
                        <img alt="{{ localized($item, 'title') }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            src="{{ $item->image_path ? asset('storage/' . $item->image_path) : 'https://via.placeholder.com/400x200?text=' . urlencode(__('ui.news_placeholder')) }}" 
                            loading="lazy" width="400" height="200" />
                    </div>
                </a>
                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex items-center gap-2 text-slate-400 text-[11px] mb-3">
                        <span class="material-symbols-outlined text-sm">calendar_month</span>
                        {{ $item->published_at?->locale(app()->getLocale())->translatedFormat('d F Y') ?? '—' }}
                    </div>
                    <h3 class="text-base font-bold mb-3 leading-tight group-hover:text-primary transition-colors">
                        <a href="{{ localized_route('news.show', ['slug' => current_slug($item)]) }}">{{ localized($item, 'title') }}</a>
                    </h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed line-clamp-3 mb-6">
                        {{ Str::limit(localized($item, 'summary') ?? localized($item, 'title'), 100) }}
                    </p>
                    <div
                        class="flex items-center justify-between mt-auto border-t border-slate-100 dark:border-slate-800/50 pt-4">
                        <a class="flex items-center gap-1 text-primary font-bold text-xs hover:translate-x-[-4px] transition-transform"
                            href="{{ localized_route('news.show', ['slug' => current_slug($item)]) }}">
                            {{ __('ui.read_more') }}
                            <span class="material-symbols-outlined text-sm rtl:rotate-180">arrow_back</span>
                        </a>
                        <button type="button" data-url="{{ url(localized_route('news.show', ['slug' => current_slug($item)])) }}"
                            onclick="navigator.clipboard.writeText(this.dataset.url)"
                            class="text-slate-400 hover:text-primary transition-colors" title="{{ __('ui.copy_link_title') }}">
                            <span class="material-symbols-outlined text-lg">share</span>
                        </button>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </section>
    @endif
</main>

@push('scripts')
{{-- Structured Data (Schema.org) for News Article --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "NewsArticle",
    "headline": {{ json_encode(localized($news, 'title')) }},
    "description": {{ json_encode(Str::limit(strip_tags(localized($news, 'summary') ?? localized($news, 'title')), 200)) }},
    "image": @if($news->image_path)["{{ asset('storage/' . $news->image_path) }}"]@else[]@endif,
    "datePublished": "{{ $news->published_at?->toIso8601String() ?? $news->created_at->toIso8601String() }}",
    "dateModified": "{{ $news->updated_at->toIso8601String() }}",
    "author": {
        "@type": "Organization",
        "name": {{ json_encode(__('ui.site_name')) }}
    },
    "publisher": {
        "@type": "Organization",
        "name": {{ json_encode(__('ui.site_name')) }},
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('assets/img/logo-l-en.svg') }}"
        }
    },
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ url()->current() }}"
    },
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
            "name": {{ json_encode(__('ui.nav_home')) }},
            "item": "{{ localized_route('home') }}"
        },
        {
            "@type": "ListItem",
            "position": 2,
            "name": {{ json_encode(__('ui.news_archive_title')) }},
            "item": "{{ localized_route('news.index') }}"
        },
        {
            "@type": "ListItem",
            "position": 3,
            "name": @json(localized($news, 'title')),
            "item": "{{ url()->current() }}"
        }
    ]
}
</script>
@endpush
@endsection
