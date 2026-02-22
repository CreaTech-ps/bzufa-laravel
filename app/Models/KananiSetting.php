<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KananiSetting extends Model
{
    protected $table = 'kanani_settings';

    protected $fillable = [
        'intro_video_url',
        'intro_text_ar',
        'intro_text_en',
        'discover_more_text_ar',
        'discover_more_text_en',
        'hero_video_url',
        'hero_badge_ar',
        'hero_badge_en',
        'hero_title_ar',
        'hero_title_en',
        'hero_subtitle_ar',
        'hero_subtitle_en',
        'hero_point1_ar',
        'hero_point1_en',
        'hero_point2_ar',
        'hero_point2_en',
        'hero_point3_ar',
        'hero_point3_en',
        'hero_media_path',
        'store_url',
        'stat1_value',
        'stat1_label_ar',
        'stat1_label_en',
        'stat2_value',
        'stat2_label_ar',
        'stat2_label_en',
        'stat3_value',
        'stat3_label_ar',
        'stat3_label_en',
        'gallery_section_title_ar',
        'gallery_section_title_en',
        'gallery_section_subtitle_ar',
        'gallery_section_subtitle_en',
        'gallery_link_text_ar',
        'gallery_link_text_en',
        'gallery_link_url',
        'cta_title_ar',
        'cta_title_en',
        'cta_subtitle_ar',
        'cta_subtitle_en',
        'cta_button_text_ar',
        'cta_button_text_en',
        'cta_button_url',
    ];

    public static function get(): self
    {
        $row = static::first();
        if ($row) {
            return $row;
        }
        return static::create([]);
    }
}
