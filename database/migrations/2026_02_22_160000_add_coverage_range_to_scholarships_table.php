<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->integer('coverage_percentage_min')->nullable()->after('coverage_percentage');
            $table->integer('coverage_percentage_max')->nullable()->after('coverage_percentage_min');
        });

        // Migrate existing coverage_percentage to both min and max for backward compatibility
        DB::table('scholarships')
            ->whereNotNull('coverage_percentage')
            ->update([
                'coverage_percentage_min' => DB::raw('coverage_percentage'),
                'coverage_percentage_max' => DB::raw('coverage_percentage'),
            ]);
    }

    public function down(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->dropColumn(['coverage_percentage_min', 'coverage_percentage_max']);
        });
    }
};
