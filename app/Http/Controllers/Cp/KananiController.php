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
        $request->validate([
            'intro_video_url' => ['nullable', 'string', 'max:500'],
            'intro_text_ar' => ['nullable', 'string'],
            'intro_text_en' => ['nullable', 'string'],
            'discover_more_text_ar' => ['nullable', 'string'],
            'discover_more_text_en' => ['nullable', 'string'],
            'hero_video_url' => ['nullable', 'string', 'max:500'],
            'store_url' => ['nullable', 'string', 'max:500'],
            'stat1_value' => ['nullable', 'string', 'max:50'],
            'stat1_label_ar' => ['nullable', 'string', 'max:255'],
            'stat2_value' => ['nullable', 'string', 'max:50'],
            'stat2_label_ar' => ['nullable', 'string', 'max:255'],
            'stat3_value' => ['nullable', 'string', 'max:50'],
            'stat3_label_ar' => ['nullable', 'string', 'max:255'],
        ]);

        KananiSetting::get()->update($request->only([
            'intro_video_url', 'intro_text_ar', 'intro_text_en',
            'discover_more_text_ar', 'discover_more_text_en',
            'hero_video_url', 'store_url',
            'stat1_value', 'stat1_label_ar', 'stat2_value', 'stat2_label_ar',
            'stat3_value', 'stat3_label_ar',
        ]));

        return redirect()->route('cp.kanani.edit')->with('success', 'تم حفظ إعدادات كنعاني بنجاح.');
    }
}
