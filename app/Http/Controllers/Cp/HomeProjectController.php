<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\HomeProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class HomeProjectController extends Controller
{
    public function index()
    {
        $projects = HomeProject::orderBy('sort_order')->orderBy('id')->get();
        return view('cp.home-projects.index', compact('projects'));
    }

    public function create()
    {
        return view('cp.home-projects.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateProject($request);
        $validated['image_path'] = $this->handleImageUpload($request);

        HomeProject::create($validated);
        Cache::forget('home_projects');

        return redirect()->route('cp.home-projects.index')->with('success', 'تم إضافة المشروع بنجاح.');
    }

    public function edit(HomeProject $home_project)
    {
        return view('cp.home-projects.edit', compact('home_project'));
    }

    public function update(Request $request, HomeProject $home_project)
    {
        $validated = $this->validateProject($request);
        unset($validated['image']);

        if ($request->hasFile('image')) {
            if ($home_project->image_path) {
                Storage::disk('public')->delete($home_project->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('cp/home-projects', 'public');
        }

        $home_project->update($validated);
        Cache::forget('home_projects');

        return redirect()->route('cp.home-projects.index')->with('success', 'تم تحديث المشروع بنجاح.');
    }

    public function destroy(HomeProject $home_project)
    {
        if ($home_project->image_path) {
            Storage::disk('public')->delete($home_project->image_path);
        }
        $home_project->delete();
        Cache::forget('home_projects');
        return redirect()->route('cp.home-projects.index')->with('success', 'تم حذف المشروع بنجاح.');
    }

    private function validateProject(Request $request): array
    {
        $validated = $request->validate([
            'title_ar' => ['required', 'string', 'max:255'],
            'title_en' => ['nullable', 'string', 'max:255'],
            'description_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'badge_1_ar' => ['nullable', 'string', 'max:100'],
            'badge_1_en' => ['nullable', 'string', 'max:100'],
            'badge_1_style' => ['nullable', 'in:dark,primary'],
            'badge_2_ar' => ['nullable', 'string', 'max:100'],
            'badge_2_en' => ['nullable', 'string', 'max:100'],
            'badge_2_style' => ['nullable', 'in:dark,primary'],
            'link_type' => ['required', 'in:route,url'],
            'link_value' => ['nullable', 'string', 'max:500'],
            'link_open_new_tab' => ['nullable', 'boolean'],
            'button_text_ar' => ['nullable', 'string', 'max:100'],
            'button_text_en' => ['nullable', 'string', 'max:100'],
            'stat_line_1_ar' => ['nullable', 'string', 'max:255'],
            'stat_line_1_en' => ['nullable', 'string', 'max:255'],
            'stat_value' => ['nullable', 'string', 'max:50'],
            'stat_suffix_ar' => ['nullable', 'string', 'max:100'],
            'stat_suffix_en' => ['nullable', 'string', 'max:100'],
            'stat_percentage' => ['nullable', 'integer', 'min:0', 'max:100'],
            'stat_line_2_ar' => ['nullable', 'string', 'max:255'],
            'stat_line_2_en' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'title_ar.required' => 'يرجى إدخال عنوان المشروع بالعربية.',
        ]);

        $validated['link_open_new_tab'] = $request->boolean('link_open_new_tab');
        $validated['is_active'] = $request->boolean('is_active', true);
        return $validated;
    }

    private function handleImageUpload(Request $request): ?string
    {
        if ($request->hasFile('image')) {
            return $request->file('image')->store('cp/home-projects', 'public');
        }
        return null;
    }
}
