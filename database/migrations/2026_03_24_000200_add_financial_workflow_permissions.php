<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $permissions = [
            ['name' => 'المالية - إضافة', 'slug' => 'financial_add', 'module' => 'المالية'],
            ['name' => 'المالية - تدقيق', 'slug' => 'financial_review', 'module' => 'المالية'],
            ['name' => 'المالية - اعتماد', 'slug' => 'financial_approve', 'module' => 'المالية'],
        ];

        foreach ($permissions as $permission) {
            $exists = DB::table('permissions')->where('slug', $permission['slug'])->exists();
            if (! $exists) {
                DB::table('permissions')->insert(array_merge($permission, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }

    public function down(): void
    {
        DB::table('permissions')->whereIn('slug', [
            'financial_add',
            'financial_review',
            'financial_approve',
        ])->delete();
    }
};

