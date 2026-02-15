<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use App\Models\AboutSection;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function edit()
    {
        $aboutPage = AboutPage::get();
        $sections = AboutSection::getForAbout();

        return view('cp.about.edit', compact('aboutPage', 'sections'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'story_video_url' => ['nullable', 'string', 'max:500'],
            'sections' => ['nullable', 'array'],
            'sections.*.id' => ['required', 'exists:about_sections,id'],
            'sections.*.title_ar' => ['required', 'string', 'max:255'],
            'sections.*.title_en' => ['nullable', 'string', 'max:255'],
            'sections.*.content_ar' => ['nullable', 'string'],
            'sections.*.content_en' => ['nullable', 'string'],
        ]);

        AboutPage::get()->update([
            'story_video_url' => $request->story_video_url,
        ]);

        if ($request->has('sections')) {
            foreach ($request->sections as $data) {
                AboutSection::where('id', $data['id'])->update([
                    'title_ar' => $data['title_ar'] ?? '',
                    'title_en' => $data['title_en'] ?? null,
                    'content_ar' => $data['content_ar'] ?? '',
                    'content_en' => $data['content_en'] ?? null,
                ]);
            }
        }

        return redirect()->route('cp.about.edit')->with('success', 'تم حفظ صفحة من نحن بنجاح.');
    }
}
