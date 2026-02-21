<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\SiteText;
use Illuminate\Http\Request;

class SiteTextController extends Controller
{
    public function index(Request $request)
    {
        $groups = config('site_content', []);
        $currentGroup = $request->query('group', array_key_first($groups) ?: 'home');

        if (!isset($groups[$currentGroup])) {
            $currentGroup = array_key_first($groups) ?: 'home';
        }

        $items = $groups[$currentGroup]['items'] ?? [];
        $labels = [
            'ar' => $groups[$currentGroup]['label_ar'] ?? $currentGroup,
            'en' => $groups[$currentGroup]['label_en'] ?? $currentGroup,
        ];

        $texts = SiteText::whereIn('key', array_keys($items))->get()->keyBy('key');

        return view('cp.site-texts.index', compact('groups', 'currentGroup', 'items', 'labels', 'texts'));
    }

    public function update(Request $request)
    {
        $group = $request->input('group');
        $groups = config('site_content', []);

        if (!isset($groups[$group])) {
            return redirect()->route('cp.site-texts.index', ['group' => $group])
                ->with('error', 'المجموعة غير صحيحة.');
        }

        $items = $groups[$group]['items'] ?? [];
        $values = $request->input('values', []);
        $sortOrder = 0;
        $orderedKeys = array_keys($items);

        foreach ($orderedKeys as $index => $key) {
            $item = $items[$key];
            $valueAr = $values[$index]['ar'] ?? null;
            $valueEn = $values[$index]['en'] ?? null;

            SiteText::updateOrCreate(
                ['key' => $key],
                [
                    'group' => $group,
                    'label_ar' => $item['label_ar'] ?? $key,
                    'label_en' => $item['label_en'] ?? $key,
                    'value_ar' => $valueAr,
                    'value_en' => $valueEn,
                    'sort_order' => $sortOrder++,
                ]
            );
        }

        return redirect()->route('cp.site-texts.index', ['group' => $group])
            ->with('success', 'تم حفظ النصوص بنجاح.');
    }
}
