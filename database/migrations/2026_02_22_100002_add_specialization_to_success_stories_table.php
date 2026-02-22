<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('success_stories', function (Blueprint $table) {
            $table->string('specialization_ar')->nullable()->after('title_en');
            $table->string('specialization_en')->nullable()->after('specialization_ar');
        });
    }

    public function down(): void
    {
        Schema::table('success_stories', function (Blueprint $table) {
            $table->dropColumn(['specialization_ar', 'specialization_en']);
        });
    }
};
