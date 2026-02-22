<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\KananiSetting;
use Illuminate\Http\Request;

class KananiController extends Controller
{
    public function edit()
    {
        $settings = KananiSetting::get();
        return view('cp.kanani.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'intro_video_url' => ['nullable', 'string', 'max:500'],
            'intro_text_ar' => ['nullable', 'string'],
            'intro_text_en' => ['nullable', 'string'],
            'discover_more_text_ar' => ['nullable', 'string'],
            'discover_more_text_en' => ['nullable', 'string'],
            'hero_video_url' => ['nullable', 'string', 'max:500'],
            'hero_badge_ar' => ['nullable', 'string', 'max:255'],
            'hero_badge_en' => ['nullable', 'string', 'max:255'],
            'hero_title_ar' => ['nullable', 'string', 'max:255'],
            'hero_title_en' => ['nullable', 'string', 'max:255'],
            'hero_subtitle_ar' => ['nullable', 'string'],
            'hero_subtitle_en' => ['nullable', 'string'],
            'hero_point1_ar' => ['nullable', 'string', 'max:255'],
            'hero_point1_en' => ['nullable', 'string', 'max:255'],
            'hero_point2_ar' => ['nullable', 'string', 'max:255'],
            'hero_point2_en' => ['nullable', 'string', 'max:255'],
            'hero_point3_ar' => ['nullable', 'string', 'max:255'],
            'hero_point3_en' => ['nullable', 'string', 'max:255'],
            'store_url' => ['nullable', 'string', 'max:500'],
            'stat1_value' => ['nullable', 'string', 'max:50'],
            'stat1_label_ar' => ['nullable', 'string', 'max:255'],
            'stat1_label_en' => ['nullable', 'string', 'max:255'],
            'stat2_value' => ['nullable', 'string', 'max:50'],
            'stat2_label_ar' => ['nullable', 'string', 'max:255'],
            'stat2_label_en' => ['nullable', 'string', 'max:255'],
            'stat3_value' => ['nullable', 'string', 'max:50'],
            'stat3_label_ar' => ['nullable', 'string', 'max:255'],
            'stat3_label_en' => ['nullable', 'string', 'max:255'],
            'gallery_section_title_ar' => ['nullable', 'string', 'max:255'],
            'gallery_section_title_en' => ['nullable', 'string', 'max:255'],
            'gallery_section_subtitle_ar' => ['nullable', 'string', 'max:500'],
            'gallery_section_subtitle_en' => ['nullable', 'string', 'max:500'],
            'gallery_link_text_ar' => ['nullable', 'string', 'max:255'],
            'gallery_link_text_en' => ['nullable', 'string', 'max:255'],
            'gallery_link_url' => ['nullable', 'string', 'max:500'],
            'cta_title_ar' => ['nullable', 'string', 'max:255'],
            'cta_title_en' => ['nullable', 'string', 'max:255'],
            'cta_subtitle_ar' => ['nullable', 'string'],
            'cta_subtitle_en' => ['nullable', 'string'],
            'cta_button_text_ar' => ['nullable', 'string', 'max:255'],
            'cta_button_text_en' => ['nullable', 'string', 'max:255'],
            'cta_button_url' => ['nullable', 'string', 'max:500'],
        ]);

        KananiSetting::get()->update($validated);

        return redirect()->route('cp.kanani.edit')->with('success', 'تم حفظ إعدادات كنعاني بنجاح.');
    }
}
