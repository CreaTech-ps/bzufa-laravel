<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parasols_settings', function (Blueprint $table) {
            $table->string('stat1_label_en')->nullable()->after('stat1_label_ar');
            $table->string('stat2_label_en')->nullable()->after('stat2_label_ar');
            $table->string('stat3_label_en')->nullable()->after('stat3_label_ar');
            $table->string('stat4_label_en')->nullable()->after('stat4_label_ar');
        });
    }

    public function down(): void
    {
        Schema::table('parasols_settings', function (Blueprint $table) {
            $table->dropColumn(['stat1_label_en', 'stat2_label_en', 'stat3_label_en', 'stat4_label_en']);
        });
    }
};
