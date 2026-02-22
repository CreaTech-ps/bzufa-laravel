@extends('cp.layout')

@section('title', 'مشروع كنعاني')

@section('content')
<div class="w-full max-w-none space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h2 class="text-xl font-bold text-slate-800 dark:text-white">إعدادات مشروع كنعاني</h2>
        <a href="{{ route('cp.kanani.gallery.index') }}" class="cp-btn inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-white font-medium shadow-sm transition-colors">
            <span class="material-symbols-outlined text-xl">photo_library</span>
            معرض الصور
        </a>
    </div>

    <form action="{{ route('cp.kanani.update') }}" method="post" class="space-y-6">
        @csrf
        @method('PUT')

        <section class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">videocam</span>
                الفيديو والنبذة
            </h2>
            <div class="space-y-4">
                <div>
                    <label for="intro_video_url" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">رابط الفيديو التعريفي</label>
                    <input type="url" name="intro_video_url" id="intro_video_url" value="{{ old('intro_video_url', $settings->intro_video_url) }}" placeholder="https://..." class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30" />
                </div>
                <div>
                    <label for="intro_text_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">نبذة عن المشروع (عربي)</label>
                    <textarea name="intro_text_ar" id="intro_text_ar" rows="4" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">{{ old('intro_text_ar', $settings->intro_text_ar) }}</textarea>
                </div>
                <div>
                    <label for="intro_text_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">نبذة عن المشروع (إنجليزي)</label>
                    <textarea name="intro_text_en" id="intro_text_en" rows="4" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">{{ old('intro_text_en', $settings->intro_text_en) }}</textarea>
                </div>
            </div>
        </section>

        <section class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">article</span>
                العنوان والنقاط (البطل)
            </h2>
            <div class="space-y-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="hero_badge_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">شارة التراث (عربي)</label>
                        <input type="text" name="hero_badge_ar" id="hero_badge_ar" value="{{ old('hero_badge_ar', $settings->hero_badge_ar) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5" />
                    </div>
                    <div>
                        <label for="hero_badge_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">شارة التراث (إنجليزي)</label>
                        <input type="text" name="hero_badge_en" id="hero_badge_en" value="{{ old('hero_badge_en', $settings->hero_badge_en) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5" />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="hero_title_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">عنوان البطل سطر 1 (عربي)</label>
                        <input type="text" name="hero_title_ar" id="hero_title_ar" value="{{ old('hero_title_ar', $settings->hero_title_ar) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5" />
                    </div>
                    <div>
                        <label for="hero_title_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">عنوان البطل سطر 2 (إنجليزي)</label>
                        <input type="text" name="hero_title_en" id="hero_title_en" value="{{ old('hero_title_en', $settings->hero_title_en) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5" />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="hero_subtitle_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">وصف البطل (عربي)</label>
                        <textarea name="hero_subtitle_ar" id="hero_subtitle_ar" rows="2" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5">{{ old('hero_subtitle_ar', $settings->hero_subtitle_ar) }}</textarea>
                    </div>
                    <div>
                        <label for="hero_subtitle_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">وصف البطل (إنجليزي)</label>
                        <textarea name="hero_subtitle_en" id="hero_subtitle_en" rows="2" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5">{{ old('hero_subtitle_en', $settings->hero_subtitle_en) }}</textarea>
                    </div>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">النقاط الثلاث:</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach([1,2,3] as $i)
                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-700/50 space-y-2">
                        <label class="cp-label text-xs font-medium">نقطة {{ $i }}</label>
                        <input type="text" name="hero_point{{ $i }}_ar" value="{{ old('hero_point'.$i.'_ar', $settings->{'hero_point'.$i.'_ar'}) }}" placeholder="عربي" class="cp-input w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm" />
                        <input type="text" name="hero_point{{ $i }}_en" value="{{ old('hero_point'.$i.'_en', $settings->{'hero_point'.$i.'_en'}) }}" placeholder="English" class="cp-input w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm" />
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">videocam</span>
                فيديو القسم الأول
            </h2>
            <div>
                <label for="hero_video_url" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">رابط الفيديو للقسم الأول (بدلاً من الصورة)</label>
                <input type="url" name="hero_video_url" id="hero_video_url" value="{{ old('hero_video_url', $settings->hero_video_url ?? '') }}" placeholder="https://youtube.com/... أو رابط فيديو مباشر" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30" />
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">سيتم عرض هذا الفيديو في القسم الأول بدلاً من الصورة</p>
            </div>
        </section>

        <section class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">article</span>
                نص "اكتشف المزيد"
            </h2>
            <div class="space-y-4">
                <div>
                    <label for="discover_more_text_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">النص الكامل (عربي)</label>
                    <textarea name="discover_more_text_ar" id="discover_more_text_ar" rows="8" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">{{ old('discover_more_text_ar', $settings->discover_more_text_ar ?? '') }}</textarea>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">النص الذي سيظهر في Lightbox عند الضغط على زر "اكتشف المزيد"</p>
                </div>
                <div>
                    <label for="discover_more_text_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">النص الكامل (إنجليزي)</label>
                    <textarea name="discover_more_text_en" id="discover_more_text_en" rows="8" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">{{ old('discover_more_text_en', $settings->discover_more_text_en ?? '') }}</textarea>
                </div>
            </div>
        </section>

        {{-- إحصائيات المشروع --}}
        <section class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">analytics</span>
                إحصائيات المشروع
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">أرقام البطاقات الثلاث (مثل: +150 حرفي، 12,000 ساعة، +500 قطعة).</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach([1,2,3] as $i)
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 space-y-2">
                    <label class="cp-label block text-xs font-medium text-slate-500 dark:text-slate-400">البطاقة {{ $i }}</label>
                    <input type="text" name="stat{{ $i }}_value" value="{{ old('stat'.$i.'_value', $settings->{'stat'.$i.'_value'}) }}" placeholder="+150" class="cp-input w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30" />
                    <input type="text" name="stat{{ $i }}_label_ar" value="{{ old('stat'.$i.'_label_ar', $settings->{'stat'.$i.'_label_ar'}) }}" placeholder="العنوان (عربي)" class="cp-input w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30" />
                    <input type="text" name="stat{{ $i }}_label_en" value="{{ old('stat'.$i.'_label_en', $settings->{'stat'.$i.'_label_en'}) }}" placeholder="Label (English)" class="cp-input w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30" />
                </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">photo_library</span>
                قسم المعرض والدعوة
            </h2>
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="gallery_section_title_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">عنوان المعرض (عربي)</label>
                        <input type="text" name="gallery_section_title_ar" id="gallery_section_title_ar" value="{{ old('gallery_section_title_ar', $settings->gallery_section_title_ar) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5" />
                    </div>
                    <div>
                        <label for="gallery_section_title_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">عنوان المعرض (إنجليزي)</label>
                        <input type="text" name="gallery_section_title_en" id="gallery_section_title_en" value="{{ old('gallery_section_title_en', $settings->gallery_section_title_en) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5" />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="gallery_section_subtitle_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">وصف المعرض (عربي)</label>
                        <input type="text" name="gallery_section_subtitle_ar" id="gallery_section_subtitle_ar" value="{{ old('gallery_section_subtitle_ar', $settings->gallery_section_subtitle_ar) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5" />
                    </div>
                    <div>
                        <label for="gallery_section_subtitle_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">وصف المعرض (إنجليزي)</label>
                        <input type="text" name="gallery_section_subtitle_en" id="gallery_section_subtitle_en" value="{{ old('gallery_section_subtitle_en', $settings->gallery_section_subtitle_en) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5" />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="gallery_link_text_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">نص رابط المعرض (عربي)</label>
                        <input type="text" name="gallery_link_text_ar" id="gallery_link_text_ar" value="{{ old('gallery_link_text_ar', $settings->gallery_link_text_ar) }}" placeholder="تصفح الكل" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5" />
                    </div>
                    <div>
                        <label for="gallery_link_text_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">نص رابط المعرض (إنجليزي)</label>
                        <input type="text" name="gallery_link_text_en" id="gallery_link_text_en" value="{{ old('gallery_link_text_en', $settings->gallery_link_text_en) }}" placeholder="Browse all" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5" />
                    </div>
                </div>
                <div>
                    <label for="gallery_link_url" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">رابط المعرض</label>
                    <input type="url" name="gallery_link_url" id="gallery_link_url" value="{{ old('gallery_link_url', $settings->gallery_link_url) }}" placeholder="https://..." class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5" />
                </div>
                <hr class="border-slate-200 dark:border-slate-600 my-4" />
                <p class="text-sm font-medium text-slate-700 dark:text-slate-300">قسم الدعوة (CTA):</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                    <div>
                        <label for="cta_title_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">عنوان الدعوة (عربي)</label>
                        <input type="text" name="cta_title_ar" id="cta_title_ar" value="{{ old('cta_title_ar', $settings->cta_title_ar) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5" />
                    </div>
                    <div>
                        <label for="cta_title_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">عنوان الدعوة (إنجليزي)</label>
                        <input type="text" name="cta_title_en" id="cta_title_en" value="{{ old('cta_title_en', $settings->cta_title_en) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5" />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="cta_subtitle_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">وصف الدعوة (عربي)</label>
                        <textarea name="cta_subtitle_ar" id="cta_subtitle_ar" rows="2" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5">{{ old('cta_subtitle_ar', $settings->cta_subtitle_ar) }}</textarea>
                    </div>
                    <div>
                        <label for="cta_subtitle_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">وصف الدعوة (إنجليزي)</label>
                        <textarea name="cta_subtitle_en" id="cta_subtitle_en" rows="2" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5">{{ old('cta_subtitle_en', $settings->cta_subtitle_en) }}</textarea>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="cta_button_text_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">نص زر الدعوة (عربي)</label>
                        <input type="text" name="cta_button_text_ar" id="cta_button_text_ar" value="{{ old('cta_button_text_ar', $settings->cta_button_text_ar) }}" placeholder="زيارة المتجر الكامل" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5" />
                    </div>
                    <div>
                        <label for="cta_button_text_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">نص زر الدعوة (إنجليزي)</label>
                        <input type="text" name="cta_button_text_en" id="cta_button_text_en" value="{{ old('cta_button_text_en', $settings->cta_button_text_en) }}" placeholder="Visit full store" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5" />
                    </div>
                </div>
                <div>
                    <label for="cta_button_url" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">رابط زر الدعوة</label>
                    <input type="url" name="cta_button_url" id="cta_button_url" value="{{ old('cta_button_url', $settings->cta_button_url) }}" placeholder="https://..." class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5" />
                </div>
            </div>
        </section>

        <section class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">store</span>
                رابط المتجر
            </h2>
            <div>
                <label for="store_url" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">رابط زيارة المتجر (CTA)</label>
                <input type="url" name="store_url" id="store_url" value="{{ old('store_url', $settings->store_url) }}" placeholder="https://..." class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30" />
            </div>
        </section>

        <div class="flex justify-end">
            <button type="submit" class="cp-btn px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-white font-medium shadow-sm transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-xl">save</span>
                حفظ التغييرات
            </button>
        </div>
    </form>
</div>
@endsection
