@extends('website.layout')

@section('title', 'فريقنا')

@section('content')
<div class="max-w-6xl mx-auto px-8 lg:px-16 py-20">
        <header class="mb-16">
            <h1 class="text-5xl md:text-6xl font-black mb-8">فريقنا</h1>
            <p class="text-xl text-slate-600 dark:text-slate-400 max-w-3xl leading-relaxed">
                نحن في جمعية أصدقاء جامعة بيرزيت نؤمن بأن التعليم هو حجر الأساس لمستقبل فلسطين. يضم فريقنا نخبة من
                الكفاءات الوطنية الملتزمة بدعم المسيرة الأكاديمية وتمكين الطلبة.
            </p>
        </header>
        @if(!empty($aboutPage->team_video_url))
        <section class="mb-24">
            <div class="relative rounded-[32px] overflow-hidden aspect-video bg-black shadow-2xl border border-slate-200 dark:border-slate-800 group">
                @php
                    $teamVideoUrl = $aboutPage->team_video_url;
                    $isYoutube = preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $teamVideoUrl, $ym);
                    $isVimeo = preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $teamVideoUrl, $vm);
                @endphp
                @if($isYoutube)
                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $ym[1] }}?rel=0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                @elseif($isVimeo)
                    <iframe class="w-full h-full" src="https://player.vimeo.com/video/{{ $vm[1] }}" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                @else
                    <video class="w-full h-full object-cover" controls src="{{ $teamVideoUrl }}"></video>
                @endif
            </div>
        </section>
        @endif
        <section class="mb-32">
            <div class="flex items-center gap-4 mb-16">
                <div class="w-2 h-10 bg-primary rounded-full"></div>
                <h2 class="text-4xl font-extrabold">مجلس الإدارة</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($boardMembers as $member)
                <div
                    class="bg-white dark:bg-card-dark p-8 rounded-[32px] border border-slate-100 dark:border-slate-800 text-center hover:shadow-2xl hover:shadow-primary/5 transition-all duration-300 group">
                    <div class="relative inline-block mb-8">
                        <div
                            class="w-40 h-40 rounded-full overflow-hidden bg-slate-100 dark:bg-slate-800 mx-auto p-1 ring-4 ring-primary/10 group-hover:ring-primary/30 transition-all">
                            <img alt="{{ $member->name_ar }}"
                                class="w-full h-full object-cover rounded-full grayscale group-hover:grayscale-0 transition-all duration-700"
                                src="{{ $member->photo_path ? asset('storage/' . $member->photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($member->name_ar) . '&size=160&background=e2e8f0&color=64748b' }}" />
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">{{ $member->name_ar }}</h3>
                    <p class="text-primary text-sm font-bold mb-6">{{ $member->title_ar }}</p>
                </div>
                @empty
                <div class="col-span-full text-center py-12 text-slate-500 dark:text-slate-400">لا يوجد أعضاء في مجلس الإدارة حالياً</div>
                @endforelse
            </div>
        </section>
        <section>
            <div class="flex items-center justify-between mb-16">
                <div class="flex items-center gap-4">
                    <div class="w-2 h-10 bg-primary rounded-full"></div>
                    <h2 class="text-4xl font-extrabold">فريق العمل</h2>
                </div>
                <div
                    class="bg-slate-100 dark:bg-card-dark px-6 py-3 rounded-2xl text-sm font-bold text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-800">
                    <span class="text-primary">{{ $executiveStaff->count() }}</span> موظفاً مخلصاً
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($executiveStaff as $member)
                <div
                    class="bg-white dark:bg-card-dark p-6 rounded-[24px] border border-slate-100 dark:border-slate-800 flex items-center justify-between hover:border-primary/30 transition-all group">
                    <div class="flex items-center gap-6">
                        <div
                            class="w-20 h-20 rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-800 ring-2 ring-transparent group-hover:ring-primary/20 transition-all">
                            <img alt="{{ $member->name_ar }}" class="w-full h-full object-cover"
                                src="{{ $member->photo_path ? asset('storage/' . $member->photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($member->name_ar) . '&size=80&background=e2e8f0&color=64748b' }}" />
                        </div>
                        <div>
                            <h4 class="text-xl font-bold mb-1">{{ $member->name_ar }}</h4>
                            <p class="text-slate-500 dark:text-slate-400">{{ $member->title_ar }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12 text-slate-500 dark:text-slate-400">لا يوجد أعضاء في فريق العمل حالياً</div>
                @endforelse
            </div>
        </section>
</div>
@endsection