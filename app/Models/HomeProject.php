<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeProject extends Model
{
    protected $fillable = [
        'title_ar', 'title_en', 'description_ar', 'description_en', 'image_path',
        'badge_1_ar', 'badge_1_en', 'badge_1_style', 'badge_2_ar', 'badge_2_en', 'badge_2_style',
        'link_type', 'link_value', 'link_open_new_tab', 'button_text_ar', 'button_text_en',
        'stat_line_1_ar', 'stat_line_1_en', 'stat_value', 'stat_suffix_ar', 'stat_suffix_en',
        'stat_percentage', 'stat_line_2_ar', 'stat_line_2_en', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'link_open_new_tab' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getTitleAttribute(): string
    {
        return localized($this, 'title');
    }

    public function getDescriptionAttribute(): string
    {
        return localized($this, 'description') ?? '';
    }

    public function getBadge1Attribute(): ?string
    {
        return localized($this, 'badge_1');
    }

    public function getBadge2Attribute(): ?string
    {
        return localized($this, 'badge_2');
    }

    public function getButtonTextAttribute(): ?string
    {
        return localized($this, 'button_text');
    }

    public function getStatLine1Attribute(): ?string
    {
        return localized($this, 'stat_line_1');
    }

    public function getStatLine2Attribute(): ?string
    {
        return localized($this, 'stat_line_2');
    }

    public function getStatSuffixAttribute(): ?string
    {
        return localized($this, 'stat_suffix');
    }

    public function getResolvedUrlAttribute(): ?string
    {
        if (!$this->link_value) {
            return null;
        }
        if ($this->link_type === 'route') {
            try {
                return localized_route($this->link_value);
            } catch (\Throwable $e) {
                return url('/');
            }
        }
        return $this->link_value;
    }

    public static function getActive()
    {
        return static::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();
    }
}
