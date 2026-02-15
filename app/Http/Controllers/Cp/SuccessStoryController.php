<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuccessStoryController extends Controller
{
    public function index(Request $request)
    {
        $query = SuccessStory::query()->orderBy('sort_order')->orderByDesc('created_at');

        if ($request->filled('featured')) {
            if ($request->featured === '1') {
                $query->where('is_featured', true);
            } elseif ($request->featured === '0') {
                $query->where('is_featured', false);
            }
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('title_ar', 'like', "%{$q}%")
                    ->orWhere('title_en', 'like', "%{$q}%")
                    ->orWhere('content_ar', 'like', "%{$q}%");
            });
        }

        $stories = $query->paginate(12)->withQueryString();

        return view('cp.success-stories.index', compact('stories'));
    }

    public function create()
    {
        $item = new SuccessStory();
        $item->sort_order = 0;
        $item->is_featured = false;
        return view('cp.success-stories.form', ['item' => $item, 'title' => 'إضافة قصة نجاح']);
    }

    public function store(Request $request)
    {
        $validated = $this->validateStory($request);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('cp/success-stories', 'public');
        }

        SuccessStory::create($validated);

        return redirect()->route('cp.success-stories.index')->with('success', 'تم إضافة القصة بنجاح.');
    }

    public function edit(SuccessStory $success_story)
    {
        return view('cp.success-stories.form', ['item' => $success_story, 'title' => 'تعديل قصة النجاح']);
    }

    public function update(Request $request, SuccessStory $success_story)
    {
        $validated = $this->validateStory($request);

        if ($request->hasFile('image')) {
            if ($success_story->image_path) {
                Storage::disk('public')->delete($success_story->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('cp/success-stories', 'public');
        }

        $success_story->update($validated);

        return redirect()->route('cp.success-stories.index')->with('success', 'تم تحديث القصة بنجاح.');
    }

    public function destroy(SuccessStory $success_story)
    {
        if ($success_story->image_path) {
            Storage::disk('public')->delete($success_story->image_path);
        }
        $success_story->delete();
        return redirect()->route('cp.success-stories.index')->with('success', 'تم حذف القصة.');
    }

    private function validateStory(Request $request): array
    {
        $validated = $request->validate([
            'title_ar' => ['required', 'string', 'max:255'],
            'title_en' => ['nullable', 'string', 'max:255'],
            'content_ar' => ['nullable', 'string'],
            'content_en' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'sort_order' => ['nullable', 'integer'],
            'is_featured' => ['nullable', 'boolean'],
        ]);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['sort_order'] = (int) ($request->sort_order ?? 0);
        return $validated;
    }
}
