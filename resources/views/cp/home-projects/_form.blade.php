@php
    $project = $project ?? new \App\Models\HomeProject();
    $isEdit = $project->exists;
@endphp

<section class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm space-y-6">
    <h3 class="text-lg font-bold text-slate-800 dark:text-white">البيانات الأساسية</h3>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div>
            <label for="title_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">العنوان (عربي) <span class="text-red-500">*</span></label>
            <input type="text" name="title_ar" id="title_ar" value="{{ old('title_ar', $project->title_ar) }}" required class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30" />
            @error('title_ar')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="title_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">العنوان (إنجليزي)</label>
            <input type="text" name="title_en" id="title_en" value="{{ old('title_en', $project->title_en) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30" />
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div>
            <label for="description_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">الوصف (عربي)</label>
            <textarea name="description_ar" id="description_ar" rows="3" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">{{ old('description_ar', $project->description_ar) }}</textarea>
        </div>
        <div>
            <label for="description_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">الوصف (إنجليزي)</label>
            <textarea name="description_en" id="description_en" rows="3" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-primary/30">{{ old('description_en', $project->description_en) }}</textarea>
        </div>
    </div>
    <div>
        <label class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">الصورة</label>
        @if($isEdit && $project->image_path)
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-2">الحالي: <img src="{{ asset('storage/' . $project->image_path) }}" alt="" class="inline-block w-24 h-16 object-cover rounded-lg"> <a href="{{ asset('storage/' . $project->image_path) }}" target="_blank" class="text-primary hover:underline">عرض</a></p>
        @endif
        <input type="file" name="image" accept="image/*" class="cp-input w-full max-w-md rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2.5 file:mr-4 file:py-2 file:rounded-lg file:border-0 file:bg-primary/10 file:text-primary" />
    </div>
</section>

<section class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm space-y-6">
    <h3 class="text-lg font-bold text-slate-800 dark:text-white">الشارات (Badges)</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="space-y-2">
            <label class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300">الشارة الأولى</label>
            <div class="flex gap-2">
                <input type="text" name="badge_1_ar" value="{{ old('badge_1_ar', $project->badge_1_ar) }}" placeholder="عربي" class="cp-input flex-1 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5 text-sm" />
                <input type="text" name="badge_1_en" value="{{ old('badge_1_en', $project->badge_1_en) }}" placeholder="English" class="cp-input flex-1 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5 text-sm" />
            </div>
            <select name="badge_1_style" class="cp-input rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm">
                <option value="dark" {{ old('badge_1_style', $project->badge_1_style) === 'dark' ? 'selected' : '' }}>داكن (أسود شفاف)</option>
                <option value="primary" {{ old('badge_1_style', $project->badge_1_style) === 'primary' ? 'selected' : '' }}>أخضر (Primary)</option>
            </select>
        </div>
        <div class="space-y-2">
            <label class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300">الشارة الثانية</label>
            <div class="flex gap-2">
                <input type="text" name="badge_2_ar" value="{{ old('badge_2_ar', $project->badge_2_ar) }}" placeholder="عربي" class="cp-input flex-1 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5 text-sm" />
                <input type="text" name="badge_2_en" value="{{ old('badge_2_en', $project->badge_2_en) }}" placeholder="English" class="cp-input flex-1 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5 text-sm" />
            </div>
            <select name="badge_2_style" class="cp-input rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm">
                <option value="dark" {{ old('badge_2_style', $project->badge_2_style) === 'dark' ? 'selected' : '' }}>داكن</option>
                <option value="primary" {{ old('badge_2_style', $project->badge_2_style) === 'primary' ? 'selected' : '' }}>أخضر</option>
            </select>
        </div>
    </div>
</section>

<section class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm space-y-6">
    <h3 class="text-lg font-bold text-slate-800 dark:text-white">الرابط وزر الإجراء</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">نوع الرابط</label>
            <select name="link_type" id="link_type" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5">
                <option value="route" {{ old('link_type', $project->link_type) === 'route' ? 'selected' : '' }}>مسار داخلي (Route)</option>
                <option value="url" {{ old('link_type', $project->link_type) === 'url' ? 'selected' : '' }}>رابط خارجي (URL)</option>
            </select>
        </div>
        <div>
            <label for="link_value" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">القيمة</label>
            <input type="text" name="link_value" id="link_value" value="{{ old('link_value', $project->link_value) }}" placeholder="tamkeen.index أو https://..." class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5" />
            <p class="text-xs text-slate-500 mt-1">للمسارات: tamkeen.index, kanani.index, parasols.index, grants.index ...</p>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <input type="checkbox" name="link_open_new_tab" id="link_open_new_tab" value="1" {{ old('link_open_new_tab', $project->link_open_new_tab) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/30" />
        <label for="link_open_new_tab" class="text-sm font-medium text-slate-700 dark:text-slate-300">فتح الرابط في تبويب جديد</label>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="button_text_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">نص الزر (عربي)</label>
            <input type="text" name="button_text_ar" id="button_text_ar" value="{{ old('button_text_ar', $project->button_text_ar) }}" placeholder="تفاصيل التدريب" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5" />
        </div>
        <div>
            <label for="button_text_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">نص الزر (إنجليزي)</label>
            <input type="text" name="button_text_en" id="button_text_en" value="{{ old('button_text_en', $project->button_text_en) }}" placeholder="Training details" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5" />
        </div>
    </div>
</section>

<section class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm space-y-6">
    <h3 class="text-lg font-bold text-slate-800 dark:text-white">إحصائيات البطاقة (شريط التقدم)</h3>
    <p class="text-sm text-slate-500 dark:text-slate-400">يمكن تركها فارغة لإخفاء شريط التقدم.</p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="stat_line_1_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">السطر الأول (عربي) — مثل: تم تدريب:</label>
            <input type="text" name="stat_line_1_ar" id="stat_line_1_ar" value="{{ old('stat_line_1_ar', $project->stat_line_1_ar) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5" />
        </div>
        <div>
            <label for="stat_line_1_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">السطر الأول (إنجليزي)</label>
            <input type="text" name="stat_line_1_en" id="stat_line_1_en" value="{{ old('stat_line_1_en', $project->stat_line_1_en) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5" />
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label for="stat_value" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">الرقم المركزي (مثال: 150)</label>
            <input type="text" name="stat_value" id="stat_value" value="{{ old('stat_value', $project->stat_value) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5" />
        </div>
        <div>
            <label for="stat_suffix_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">لاحقة الرقم (عربي) — مثل: طالب</label>
            <input type="text" name="stat_suffix_ar" id="stat_suffix_ar" value="{{ old('stat_suffix_ar', $project->stat_suffix_ar) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5" />
        </div>
        <div>
            <label for="stat_suffix_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">لاحقة الرقم (إنجليزي)</label>
            <input type="text" name="stat_suffix_en" id="stat_suffix_en" value="{{ old('stat_suffix_en', $project->stat_suffix_en) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5" />
        </div>
    </div>
    <div>
        <label for="stat_percentage" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">نسبة شريط التقدم (0-100)</label>
        <input type="number" name="stat_percentage" id="stat_percentage" value="{{ old('stat_percentage', $project->stat_percentage) }}" min="0" max="100" class="cp-input w-32 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5" />
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="stat_line_2_ar" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">السطر الثاني (عربي) — مثل: الهدف السنوي: 180 متدرب</label>
            <input type="text" name="stat_line_2_ar" id="stat_line_2_ar" value="{{ old('stat_line_2_ar', $project->stat_line_2_ar) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5" />
        </div>
        <div>
            <label for="stat_line_2_en" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">السطر الثاني (إنجليزي)</label>
            <input type="text" name="stat_line_2_en" id="stat_line_2_en" value="{{ old('stat_line_2_en', $project->stat_line_2_en) }}" class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5" />
        </div>
    </div>
</section>

<section class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm space-y-4">
    <h3 class="text-lg font-bold text-slate-800 dark:text-white">إعدادات عامة</h3>
    <div class="flex items-center gap-4">
        <div>
            <label for="sort_order" class="cp-label block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">ترتيب العرض</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}" min="0" class="cp-input w-24 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5" />
        </div>
        <div class="flex items-center gap-2 pt-6">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $project->is_active ?? true) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/30" />
            <label for="is_active" class="text-sm font-medium text-slate-700 dark:text-slate-300">نشط (يظهر في الصفحة الرئيسية)</label>
        </div>
    </div>
</section>
