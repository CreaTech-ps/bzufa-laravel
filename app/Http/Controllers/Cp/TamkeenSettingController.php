<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\TamkeenSetting;
use Illuminate\Http\Request;

class TamkeenSettingController extends Controller
{
    public function edit()
    {
        $settings = TamkeenSetting::get();
        return view('cp.tamkeen.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'sectors' => ['nullable', 'array'],
            'sectors.*.key' => ['required', 'string', 'max:50'],
            'sectors.*.label_ar' => ['required', 'string', 'max:100'],
            'sectors.*.label_en' => ['required', 'string', 'max:100'],
        ]);

        $sectors = [];
        foreach ($request->input('sectors', []) as $idx => $row) {
            if (!empty($row['key'] ?? '') && (!empty($row['label_ar'] ?? '') || !empty($row['label_en'] ?? ''))) {
                $sectors[] = [
                    'key' => $row['key'],
                    'label_ar' => $row['label_ar'] ?? '',
                    'label_en' => $row['label_en'] ?? '',
                ];
            }
        }

        $settings = TamkeenSetting::get();
        $settings->update(['sectors' => empty($sectors) ? TamkeenSetting::defaultSectors() : $sectors]);

        return redirect()->route('cp.tamkeen.settings.edit')->with('success', 'تم حفظ إعدادات قطاعات تمكين بنجاح.');
    }
}
