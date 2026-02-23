<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parasols_settings', function (Blueprint $table) {
            $table->string('cta_secondary_pdf_path')->nullable()->after('cta_secondary_url');
        });
    }

    public function down(): void
    {
        Schema::table('parasols_settings', function (Blueprint $table) {
            $table->dropColumn('cta_secondary_pdf_path');
        });
    }
};
