<?php

namespace App\Console\Commands;

use App\Models\SiteText;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ResetSiteTextGroup extends Command
{
    protected $signature = 'site-texts:reset-group {group}';

    protected $description = 'إعادة تعيين قيم مجموعة site_texts من ملفات الترجمة الأصلية';

    private function getFromLangFile(string $locale, string $key): ?string
    {
        $parts = explode('.', $key);
        $file = array_shift($parts);
        $path = base_path("lang/{$locale}/{$file}.php");

        if (!is_file($path)) {
            return null;
        }

        $lines = require $path;

        return Arr::get($lines, implode('.', $parts));
    }

    public function handle(): int
    {
        $groupSlug = $this->argument('group');
        $groups = config('site_content', []);

        if (!isset($groups[$groupSlug])) {
            $this->error("المجموعة «{$groupSlug}» غير موجودة.");

            return 1;
        }

        $items = $groups[$groupSlug]['items'] ?? [];
        $sortOrder = 0;
        $count = count($items);

        foreach ($items as $key => $item) {
            $valueAr = $this->getFromLangFile('ar', $key);
            $valueEn = $this->getFromLangFile('en', $key);
            $valueAr = is_string($valueAr) ? $valueAr : null;
            $valueEn = is_string($valueEn) ? $valueEn : null;

            SiteText::updateOrCreate(
                ['key' => $key],
                [
                    'group' => $groupSlug,
                    'label_ar' => $item['label_ar'] ?? $key,
                    'label_en' => $item['label_en'] ?? $key,
                    'value_ar' => $valueAr,
                    'value_en' => $valueEn,
                    'sort_order' => $sortOrder++,
                ]
            );
        }

        $this->info("تم إعادة تعيين {$count} نصاً لمجموعة «{$groupSlug}».");

        return 0;
    }
}
