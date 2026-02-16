@extends('website.layout')

@section('title', $news->title_ar)
    
@section('content')
<main class="max-w-7xl mx-auto px-6 lg:px-12 xl:px-16 pt-8 pb-20">
    {{-- Breadcrumb --}}
    <nav class="flex items-center text-xs gap-2 text-slate-500 dark:text-slate-400 mb-8">
        <a class="hover:text-primary transition-colors" href="{{ route('home') }}">الرئيسية</a>
        <span class="material-symbols-outlined text-[14px]">chevron_left</span>
        <a class="hover:text-primary transition-colors" href="{{ route('news.index') }}">أرشيف الأخبار</a>
        <span class="material-symbols-outlined text-[14px]">chevron_left</span>
        <span class="text-text-dark-gray dark:text-white font-semibold line-clamp-1">{{ $news->title_ar }}</span>
    </nav>

    {{-- Header --}}
    <div class="mb-10 text-center max-w-4xl mx-auto">
        <div class="flex items-center justify-center gap-3 mb-4 flex-wrap">
            <span class="text-slate-400 text-sm font-medium flex items-center gap-1">
                <span class="material-symbols-outlined text-base">calendar_month</span>
                {{ $news->published_at?->locale('ar')->translatedFormat('d F Y') ?? '—' }}
            </span>
        </div>
        <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 dark:text-white mb-8 leading-tight">
            {{ $news->title_ar }}
        </h1>
        <div class="flex items-center justify-center gap-4 flex-wrap">
            <button type="button" id="news-share-btn"
                class="w-10 h-10 rounded-full bg-slate-100 dark:bg-bg-dark-card flex items-center justify-center hover:bg-primary hover:text-white transition-all text-slate-500"
                title="مشاركة">
                <span class="material-symbols-outlined text-lg">share</span>
            </button>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($news->title_ar) }}"
                target="_blank" rel="noopener"
                class="w-10 h-10 rounded-full bg-slate-100 dark:bg-bg-dark-card flex items-center justify-center hover:bg-[#1DA1F2] hover:text-white transition-all text-slate-500"
                title="تغريد">
                <span class="material-symbols-outlined text-lg">public</span>
            </a>
            <a href="https://wa.me/?text={{ urlencode($news->title_ar . ' ' . request()->url()) }}"
                target="_blank" rel="noopener"
                class="w-10 h-10 rounded-full bg-slate-100 dark:bg-bg-dark-card flex items-center justify-center hover:bg-[#25D366] hover:text-white transition-all text-slate-500"
                title="واتساب">
                <span class="material-symbols-outlined text-lg">chat</span>
            </a>
            <button type="button" onclick="navigator.clipboard.writeText(window.location.href); this.title='تم النسخ!';"
                class="w-10 h-10 rounded-full bg-slate-100 dark:bg-bg-dark-card flex items-center justify-center hover:bg-[#0A66C2] hover:text-white transition-all text-slate-500"
                title="نسخ الرابط">
                <span class="material-symbols-outlined text-lg">link</span>
            </button>
        </div>
        <script>
        document.getElementById('news-share-btn')?.addEventListener('click', function() {
            var url = window.location.href;
            var title = @json($news->title_ar);
            var text = @json(Str::limit(strip_tags($news->summary_ar ?? $news->title_ar), 100));
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
        class="w-full h-[300px] md:h-[500px] rounded-[2rem] overflow-hidden mb-12 shadow-2xl border border-slate-200 dark:border-slate-800">
        <img alt="{{ $news->title_ar }}" class="w-full h-full object-cover"
            src="{{ asset('storage/' . $news->image_path) }}" />
    </div>
    @endif

    {{-- Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <div class="lg:col-span-8 rich-text text-slate-700 dark:text-slate-300 prose prose-lg dark:prose-invert max-w-none">
            @if($news->summary_ar && !$news->content_ar)
            <p class="mb-6 text-lg leading-relaxed">{{ $news->summary_ar }}</p>
            @elseif($news->content_ar)
            {!! $news->content_ar !!}
            @else
            <p class="mb-6 text-lg leading-relaxed">{{ $news->summary_ar ?? $news->title_ar }}</p>
            @endif
        </div>
    </div>

    {{-- Related News --}}
    @if($relatedNews->isNotEmpty())
    <section class="mt-20">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">أخبار ذات صلة</h2>
            <a class="text-primary font-bold text-sm flex items-center gap-1 hover:gap-2 transition-all"
                href="{{ route('news.index') }}">
                كل الأخبار
                <span class="material-symbols-outlined text-sm">arrow_back</span>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($relatedNews as $item)
            <article
                class="bg-white dark:bg-bg-dark-card rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 hover:shadow-xl transition-all group flex flex-col">
                <a href="{{ route('news.show', $item->slug_ar ?: $item->id) }}">
                    <div class="relative h-44 overflow-hidden">
                        <img alt="{{ $item->title_ar }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            src="{{ $item->image_path ? asset('storage/' . $item->image_path) : 'https://via.placeholder.com/400x200?text=خبر' }}" />
                    </div>
                </a>
                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex items-center gap-2 text-slate-400 text-[11px] mb-3">
                        <span class="material-symbols-outlined text-sm">calendar_month</span>
                        {{ $item->published_at?->locale('ar')->translatedFormat('d F Y') ?? '—' }}
                    </div>
                    <h3 class="text-base font-bold mb-3 leading-tight group-hover:text-primary transition-colors">
                        <a href="{{ route('news.show', $item->slug_ar ?: $item->id) }}">{{ $item->title_ar }}</a>
                    </h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed line-clamp-3 mb-6">
                        {{ Str::limit($item->summary_ar ?? $item->title_ar, 100) }}
                    </p>
                    <div
                        class="flex items-center justify-between mt-auto border-t border-slate-100 dark:border-slate-800/50 pt-4">
                        <a class="flex items-center gap-1 text-primary font-bold text-xs hover:translate-x-[-4px] transition-transform"
                            href="{{ route('news.show', $item->slug_ar ?: $item->id) }}">
                            اقرأ المزيد
                            <span class="material-symbols-outlined text-sm">arrow_back</span>
                        </a>
                        <button type="button" data-url="{{ url(route('news.show', $item->slug_ar ?: $item->id)) }}"
                            onclick="navigator.clipboard.writeText(this.dataset.url)"
                            class="text-slate-400 hover:text-primary transition-colors" title="نسخ الرابط">
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
@endsection
