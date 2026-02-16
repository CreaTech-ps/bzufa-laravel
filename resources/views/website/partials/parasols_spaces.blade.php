<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($images as $item)
    <div
        class="bg-white dark:bg-surface-dark rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800/50 group transition-all hover:shadow-2xl">
        <div class="relative h-64 overflow-hidden">
            <img alt="{{ $item->title_ar }}"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('assets/img/logo-l.svg') }}" />
            <div class="absolute top-4 right-4">
                @if($item->status === 'ended')
                <span
                    class="bg-slate-500 text-white text-[10px] font-black px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-lg">
                    <span class="material-symbols-outlined text-xs">block</span>
                    منتهية
                </span>
                @elseif($item->status === 'ending_soon')
                <span
                    class="bg-orange-500 text-white text-[10px] font-black px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-lg">
                    <span class="material-symbols-outlined text-xs">timer</span>
                    ينتهي قريباً
                </span>
                @else
                <span
                    class="bg-green-500 text-white text-[10px] font-black px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-lg">
                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                    متاح حالياً
                </span>
                @endif
            </div>
        </div>
        <div class="p-8">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xl font-bold group-hover:text-primary transition-colors dark:text-white">{{ $item->title_ar }}</h3>
                <p class="text-primary font-black text-xl">${{ $item->price ?? '—' }}<span class="text-xs text-gray-500 font-normal">/شهر</span></p>
            </div>
            @if($item->location_ar)
            <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400 text-sm mb-7">
                <span class="material-symbols-outlined text-sm">location_on</span>
                <span>{{ $item->location_ar }}</span>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-16 text-slate-500 dark:text-slate-400">
        لا توجد مساحات معروضة حالياً
    </div>
    @endforelse
</div>
