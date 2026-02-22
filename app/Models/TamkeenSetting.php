<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TamkeenSetting extends Model
{
    protected $table = 'tamkeen_settings';

    protected $fillable = ['sectors'];

    protected $casts = [
        'sectors' => 'array',
    ];

    public static function get(): self
    {
        $row = static::first();
        if ($row) {
            return $row;
        }
        $row = static::create(['sectors' => self::defaultSectors()]);
        return $row;
    }

    public static function defaultSectors(): array
    {
        return [
            ['key' => 'tech', 'label_ar' => 'القطاع التقني', 'label_en' => 'Technology sector'],
            ['key' => 'banking', 'label_ar' => 'القطاع المصرفي', 'label_en' => 'Banking sector'],
            ['key' => 'industry', 'label_ar' => 'الصناعة', 'label_en' => 'Industry'],
            ['key' => 'logistics', 'label_ar' => 'الخدمات اللوجستية', 'label_en' => 'Logistics'],
        ];
    }

    public function getSectorsForLocale(string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();
        $sectors = $this->sectors ?? self::defaultSectors();
        $result = [];
        foreach ($sectors as $s) {
            $key = $s['key'] ?? '';
            $label = ($locale === 'ar') ? ($s['label_ar'] ?? $s['label_en'] ?? $key) : ($s['label_en'] ?? $s['label_ar'] ?? $key);
            $result[$key] = $label;
        }
        return $result;
    }
}
