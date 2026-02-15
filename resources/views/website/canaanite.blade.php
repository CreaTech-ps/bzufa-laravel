@extends('website.layout')
@section('title', 'مشروع كنعاني - دعم الحرف التراثية')
@section('content')
<section class="relative pt-24 pb-36 overflow-hidden hero-gradient-canaani">
    <div class="layout-container grid lg:grid-cols-2 gap-16 items-center">
        <div class="space-y-8">
            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-sm font-bold border border-primary/20">
                <span class="material-symbols-outlined text-sm">history_edu</span>
                {{ $settings->hero_badge_ar ?? 'تراثنا هويتنا' }}
            </div>
            <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight">
                {{ $settings->hero_title_ar ?? 'مشروع دعم' }} <br />
                <span class="text-primary">{{ $settings->hero_title_en ?? 'الحرف التراثية' }}</span>
            </h1>
            <p class="text-lg text-slate-600 dark:text-slate-400 max-w-xl leading-relaxed">
                {{ $settings->hero_subtitle_ar ?? $settings->intro_text_ar ?? 'نسعى في جمعية أصدقاء جامعة بيرزيت إلى تمكين الطلبة والحرفيين المحليين من خلال إحياء المهارات التقليدية الفلسطينية، موفرين منصة مستدامة لعرض إبداعاتهم وتأمين مستقبل كريم لهم.' }}
            </p>
            <ul class="space-y-4">
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary font-bold">check_circle</span>
                    <span class="font-medium text-lg">{{ $settings->hero_point1_ar ?? 'الحفاظ على فنون التطريز والنسيج الأصيل' }}</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary font-bold">check_circle</span>
                    <span class="font-medium text-lg">{{ $settings->hero_point2_ar ?? 'دعم وتمكين طلبة جامعة بيرزيت اقتصادياً' }}</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary font-bold">check_circle</span>
                    <span class="font-medium text-lg">{{ $settings->hero_point3_ar ?? 'تعزيز الوعي الثقافي حول الهوية الكنعانية' }}</span>
                </li>
            </ul>
        </div>
        <div class="relative group">
            <div
                class="aspect-[4/3] bg-slate-200 dark:bg-surface-dark rounded-3xl overflow-hidden shadow-2xl relative border border-white/5">
                @if($settings->intro_video_url)
                <a href="{{ $settings->intro_video_url }}" target="_blank" rel="noopener" class="block w-full h-full">
                    <img alt="Artisan working"
                        class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-700"
                        src="{{ $settings->hero_media_path ? asset('storage/' . $settings->hero_media_path) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuBJOUJgf4WcAhudRUzG3VkOBNzke38IAovPO0iIHQgD9LPohQYerjqPTslkt1Mk_KvrjaGg7iL3RgXTNIrlFkw12uN4hZ5bSyKXguW7-TPnDJ1yP9O61Xao8jyCGjFuVgRVGY1N9FkT0ZM7XdA2BL_fLe2izZEcpSLRzlDB85n6nSYxkzuJuLMUMzOWXDSVG60PXETq1wEwBFhqNDI_RqV01oqrQNIn-CRiT7TFlWqYzWBPse4Q2PXt8OathdC-yohMP9TDijLBFBo' }}" />
                    <div class="absolute inset-0 flex items-center justify-center bg-black/20">
                        <span class="w-20 h-20 bg-primary rounded-full flex items-center justify-center text-white shadow-lg shadow-primary/40 transform transition group-hover:scale-110 group-hover:rotate-12">
                            <span class="material-symbols-outlined text-4xl fill-current">play_arrow</span>
                        </span>
                    </div>
                </a>
                @else
                <img alt="Artisan working"
                    class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-700"
                    src="{{ $settings->hero_media_path ? asset('storage/' . $settings->hero_media_path) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuBJOUJgf4WcAhudRUzG3VkOBNzke38IAovPO0iIHQgD9LPohQYerjqPTslkt1Mk_KvrjaGg7iL3RgXTNIrlFkw12uN4hZ5bSyKXguW7-TPnDJ1yP9O61Xao8jyCGjFuVgRVGY1N9FkT0ZM7XdA2BL_fLe2izZEcpSLRzlDB85n6nSYxkzuJuLMUMzOWXDSVG60PXETq1wEwBFhqNDI_RqV01oqrQNIn-CRiT7TFlWqYzWBPse4Q2PXt8OathdC-yohMP9TDijLBFBo' }}" />
                @endif
            </div>
            <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-primary/20 rounded-full blur-[80px] -z-10">
            </div>
        </div>
    </div>
</section>
<section class="layout-container -mt-16 relative z-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
            class="bg-white dark:bg-surface-dark p-8 rounded-2xl shadow-xl border border-slate-100 dark:border-white/5 flex items-center justify-between group transition-all hover:-translate-y-2">
            <div>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-1 font-semibold">{{ $settings->stat1_label_ar ?? 'حرفيون مدعومون' }}</p>
                <h3 class="text-4xl font-extrabold text-primary">{{ $settings->stat1_value ?? '+150' }}</h3>
            </div>
            <div class="w-14 h-14 bg-slate-50 dark:bg-white/5 rounded-xl flex items-center justify-center">
                <span
                    class="material-symbols-outlined text-3xl text-slate-400 group-hover:text-primary transition-colors">groups</span>
            </div>
        </div>
        <div
            class="bg-white dark:bg-surface-dark p-8 rounded-2xl shadow-xl border border-slate-100 dark:border-white/5 flex items-center justify-between group transition-all hover:-translate-y-2">
            <div>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-1 font-semibold">{{ $settings->stat2_label_ar ?? 'ساعات من العمل اليدوي' }}</p>
                <h3 class="text-4xl font-extrabold text-primary">{{ $settings->stat2_value ?? '12,000' }}</h3>
            </div>
            <div class="w-14 h-14 bg-slate-50 dark:bg-white/5 rounded-xl flex items-center justify-center">
                <span
                    class="material-symbols-outlined text-3xl text-slate-400 group-hover:text-primary transition-colors">precision_manufacturing</span>
            </div>
        </div>
        <div
            class="bg-white dark:bg-surface-dark p-8 rounded-2xl shadow-xl border border-slate-100 dark:border-white/5 flex items-center justify-between group transition-all hover:-translate-y-2">
            <div>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-1 font-semibold">{{ $settings->stat3_label_ar ?? 'قطعة تراثية فريدة' }}</p>
                <h3 class="text-4xl font-extrabold text-primary">{{ $settings->stat3_value ?? '+500' }}</h3>
            </div>
            <div class="w-14 h-14 bg-slate-50 dark:bg-white/5 rounded-xl flex items-center justify-center">
                <span
                    class="material-symbols-outlined text-3xl text-slate-400 group-hover:text-primary transition-colors">brush</span>
            </div>
        </div>
    </div>
</section>
<section class="layout-container py-32">
    <div class="flex items-end justify-between mb-16">
        <div>
            <h2 class="text-4xl font-bold mb-3">{{ $settings->gallery_section_title_ar ?? 'مجموعة المتجر الحرفي' }}</h2>
            <p class="text-lg text-slate-500 dark:text-slate-400">{{ $settings->gallery_section_subtitle_ar ?? 'كل عملية شراء تدعم مباشرة العائلات الحرفية وطلبتنا في بيرزيت' }}</p>
        </div>
        @if(!empty($settings->store_url) || !empty($settings->gallery_link_url))
        <a class="flex items-center gap-3 text-primary font-bold text-lg hover:gap-5 transition-all" href="{{ $settings->gallery_link_url ?? $settings->store_url ?? '#' }}">
            {{ $settings->gallery_link_text_ar ?? 'تصفح الكل' }}
            <span class="material-symbols-outlined">west</span>
        </a>
        @endif
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($items as $item)
        <div class="group product-card p-3 transition-all duration-300">
            <div
                class="product-card-image-container relative aspect-[3/4] bg-slate-100 dark:bg-surface-dark rounded-2xl mb-5 border border-white/5">
                <img alt="{{ $item->title_ar }}"
                    class="w-full h-full object-cover transition-transform duration-500"
                    src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('assets/img/logo-l.svg') }}" />
                @if($item->badge === 'handcrafted')
                <div class="absolute top-5 right-5 bg-primary text-white text-[11px] font-bold px-3 py-1.5 rounded-full shadow-lg">يدوي بالكامل</div>
                @elseif($item->badge === 'bestseller')
                <div class="absolute top-5 right-5 bg-orange-500 text-white text-[11px] font-bold px-3 py-1.5 rounded-full shadow-lg">الأكثر مبيعاً</div>
                @endif
            </div>
            <h4 class="product-title font-bold text-xl mb-1 transition-colors duration-300">{{ $item->title_ar }}</h4>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-4 font-medium">{{ $item->location_ar ?? '' }}</p>
            <p class="product-price text-primary font-bold text-2xl transition-all duration-300">{{ $item->price ? '$' . $item->price : '—' }}</p>
        </div>
        @empty
        <div class="col-span-full text-center py-16 text-slate-500 dark:text-slate-400">
            لا توجد منتجات في المعرض حالياً
        </div>
        @endforelse
    </div>
</section>
@if(!empty($settings->store_url) || !empty($settings->cta_button_url))
<section class="layout-container pb-32">
    <div
        class="relative rounded-[2.5rem] overflow-hidden bg-slate-900 dark:bg-surface-dark py-20 lg:py-28 text-center px-12">
        <div class="absolute inset-0 opacity-20 pointer-events-none">
            <img alt="Pattern background" class="w-full h-full object-cover"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAfz0g8VNYlCc8yJm1qL_WpzBYnV-bNJobp0kqGWaMxmbwe4P5KXXcHIlOVj3PQBqUxCU-nDctuBAxFLmwK5O8ghJYxdnnza29cCwQlntDGycTw-a5ZqkHXNfU4y0RRBXZL6d64C1pgFAnRPidUUKHXZIalYaEP8_GJPujKqF5K8Y1UXRwkiQKZtlwJkgACJPWw09i2WBax8J_a0jAY9acs-YyY0s8_clKJFsKr3dy3NyyVbgrgYaMgfwMvQy8B18V57nm4XxHLK9E" />
        </div>
        <div class="relative z-10 max-w-2xl mx-auto">
            <h2 class="text-4xl lg:text-5xl font-extrabold text-white mb-8 leading-tight">{{ $settings->cta_title_ar ?? 'احمل جزءاً من التراث إلى منزلك' }}</h2>
            <p class="text-slate-300 mb-12 text-lg leading-relaxed">{{ $settings->cta_subtitle_ar ?? 'استدامة الفن والحياة الكريمة لمجتمعاتنا تبدأ من هنا. شاركنا رحلة الحفاظ على الجذور.' }}</p>
            <a href="{{ $settings->cta_button_url ?? $settings->store_url }}" target="_blank" rel="noopener"
                class="bg-primary hover:bg-opacity-90 text-white px-10 py-4 rounded-2xl font-bold text-xl transition-all transform hover:scale-105 inline-flex items-center gap-4 shadow-xl shadow-primary/20">
                <span class="material-symbols-outlined text-2xl">shopping_bag</span>
                {{ $settings->cta_button_text_ar ?? 'زيارة المتجر الكامل' }}
            </a>
        </div>
    </div>
</section>
@endif
@endsection