<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'إعدادات الموقع', 'slug' => 'settings', 'module' => 'إعدادات'],
            ['name' => 'الصفحة الرئيسية', 'slug' => 'home', 'module' => 'الصفحة الرئيسية'],
            ['name' => 'من نحن والفريق', 'slug' => 'about', 'module' => 'صفحات ثابتة'],
            ['name' => 'كنعاني', 'slug' => 'kanani', 'module' => 'المشاريع'],
            ['name' => 'شراكات تمكين', 'slug' => 'tamkeen', 'module' => 'المشاريع'],
            ['name' => 'المظلات', 'slug' => 'parasols', 'module' => 'المشاريع'],
            ['name' => 'المنح الجامعية', 'slug' => 'scholarships', 'module' => 'المنح'],
            ['name' => 'شركاء النجاح', 'slug' => 'partners', 'module' => 'المنح والشراكات'],
            ['name' => 'الأخبار وقصص النجاح', 'slug' => 'content', 'module' => 'المحتوى'],
            ['name' => 'طلبات المنح والتطوع والشراكات', 'slug' => 'applications', 'module' => 'الطلبات'],
            ['name' => 'النشرة الإخبارية', 'slug' => 'newsletter', 'module' => 'النشرة'],
            ['name' => 'المالية والتبرعات', 'slug' => 'financial', 'module' => 'المالية'],
            ['name' => 'إدارة المستخدمين والصلاحيات', 'slug' => 'users', 'module' => 'النظام'],
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['slug' => $p['slug']], $p);
        }

        $adminRole = Role::firstOrCreate(['slug' => 'admin'], [
            'name' => 'مدير',
            'description' => 'صلاحيات كاملة للوحة التحكم',
        ]);
        $adminRole->permissions()->sync(Permission::pluck('id'));

        $editorRole = Role::firstOrCreate(['slug' => 'editor'], [
            'name' => 'محرر',
            'description' => 'صلاحيات المحتوى والطلبات بدون إعدادات أو مستخدمين',
        ]);
        $editorRole->permissions()->sync(
            Permission::whereIn('slug', ['home', 'about', 'kanani', 'tamkeen', 'parasols', 'scholarships', 'partners', 'content', 'applications', 'newsletter', 'financial'])->pluck('id')
        );

        // إنشاء مستخدم مدير إذا لم يوجد
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make('password'),
                'is_super_admin' => true,
                'role_id' => $adminRole->id,
                'is_active' => true,
            ]
        );
        if (!$admin->is_super_admin) {
            $admin->update(['is_super_admin' => true, 'role_id' => $adminRole->id]);
        }
    }
}
