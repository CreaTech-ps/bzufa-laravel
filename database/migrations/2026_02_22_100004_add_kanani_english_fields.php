<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kanani_settings', function (Blueprint $table) {
            $table->string('hero_badge_en')->nullable()->after('hero_badge_ar');
            $table->string('hero_point1_en')->nullable()->after('hero_point3_ar');
            $table->string('hero_point2_en')->nullable()->after('hero_point1_en');
            $table->string('hero_point3_en')->nullable()->after('hero_point2_en');
            $table->string('stat1_label_en')->nullable()->after('stat1_label_ar');
            $table->string('stat2_label_en')->nullable()->after('stat2_label_ar');
            $table->string('stat3_label_en')->nullable()->after('stat3_label_ar');
            $table->string('gallery_section_title_en')->nullable()->after('gallery_section_title_ar');
            $table->string('gallery_section_subtitle_en')->nullable()->after('gallery_section_subtitle_ar');
            $table->string('gallery_link_text_en')->nullable()->after('gallery_link_text_ar');
            $table->string('cta_title_en')->nullable()->after('cta_title_ar');
            $table->text('cta_subtitle_en')->nullable()->after('cta_subtitle_ar');
            $table->string('cta_button_text_en')->nullable()->after('cta_button_text_ar');
        });
    }

    public function down(): void
    {
        Schema::table('kanani_settings', function (Blueprint $table) {
            $table->dropColumn([
                'hero_badge_en', 'hero_point1_en', 'hero_point2_en', 'hero_point3_en',
                'stat1_label_en', 'stat2_label_en', 'stat3_label_en',
                'gallery_section_title_en', 'gallery_section_subtitle_en', 'gallery_link_text_en',
                'cta_title_en', 'cta_subtitle_en', 'cta_button_text_en',
            ]);
        });
    }
};
