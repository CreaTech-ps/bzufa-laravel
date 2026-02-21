<?php

namespace Database\Seeders;

use App\Models\HomeProject;
use Illuminate\Database\Seeder;

class HomeProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title_ar' => 'مشروع تمكين الطلبة',
                'title_en' => 'Student Empowerment Project',
                'description_ar' => 'توفير ورش عمل ودورات متخصصة بالتعاون مع كبرى الشركات لتهيئة الطلبة لسوق العمل واكتساب مهارات عملية.',
                'description_en' => 'Providing workshops and specialized courses in partnership with leading companies to prepare students for the job market and gain practical skills.',
                'image_path' => null,
                'badge_1_ar' => 'تدريب',
                'badge_1_en' => 'Training',
                'badge_1_style' => 'dark',
                'badge_2_ar' => null,
                'badge_2_en' => null,
                'badge_2_style' => 'dark',
                'link_type' => 'route',
                'link_value' => 'tamkeen.index',
                'link_open_new_tab' => false,
                'button_text_ar' => 'تفاصيل التدريب',
                'button_text_en' => 'Training details',
                'stat_line_1_ar' => 'تم تدريب:',
                'stat_line_1_en' => 'Trained:',
                'stat_value' => '150',
                'stat_suffix_ar' => 'طالب',
                'stat_suffix_en' => 'students',
                'stat_percentage' => 85,
                'stat_line_2_ar' => 'الهدف السنوي: 180 متدرب',
                'stat_line_2_en' => 'Annual goal: 180 trainees',
                'sort_order' => 0,
                'is_active' => true,
            ],
            [
                'title_ar' => 'متجر كنعاني',
                'title_en' => 'Kanani Store',
                'description_ar' => 'تغطية الرسوم الدراسية للطلبة المتفوقين الذين يواجهون صعوبات اقتصادية لمواصلة رحلتهم التعليمية.',
                'description_en' => 'Covering tuition fees for outstanding students facing economic difficulties to continue their educational journey.',
                'image_path' => null,
                'badge_1_ar' => 'متجرنا',
                'badge_1_en' => 'Our Store',
                'badge_1_style' => 'primary',
                'badge_2_ar' => 'يد-بيد',
                'badge_2_en' => 'Hand in Hand',
                'badge_2_style' => 'dark',
                'link_type' => 'url',
                'link_value' => 'https://kanani.bzufa.com/',
                'link_open_new_tab' => true,
                'button_text_ar' => 'زيارة متجرنا',
                'button_text_en' => 'Visit our store',
                'stat_line_1_ar' => 'تم تقديم:',
                'stat_line_1_en' => 'Provided:',
                'stat_value' => '420',
                'stat_suffix_ar' => 'منحة',
                'stat_suffix_en' => 'scholarships',
                'stat_percentage' => 70,
                'stat_line_2_ar' => 'الهدف السنوي: 600 منحة',
                'stat_line_2_en' => 'Annual goal: 600 scholarships',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title_ar' => 'مشروع المظلات',
                'title_en' => 'Parasols Project',
                'description_ar' => 'هو مشروع خيري يعمل على تأجير المساحات الإعلانية في أماكن مميزة وتغطية دراسة الطلاب المستحقين للمنح.',
                'description_en' => 'A charitable project that rents advertising spaces in prime locations and covers the studies of deserving scholarship students.',
                'image_path' => null,
                'badge_1_ar' => 'إستدامة',
                'badge_1_en' => 'Sustainability',
                'badge_1_style' => 'primary',
                'badge_2_ar' => 'صندوق للطلبة',
                'badge_2_en' => 'Student Fund',
                'badge_2_style' => 'dark',
                'link_type' => 'route',
                'link_value' => 'parasols.index',
                'link_open_new_tab' => false,
                'button_text_ar' => 'عرض الشواغر',
                'button_text_en' => 'View vacancies',
                'stat_line_1_ar' => 'نسبة المساحات الشاغرة:',
                'stat_line_1_en' => 'Vacancy rate:',
                'stat_value' => null,
                'stat_suffix_ar' => null,
                'stat_suffix_en' => null,
                'stat_percentage' => 62,
                'stat_line_2_ar' => 'الهدف: الوصول ل 130% من الهدف السنوي السابق',
                'stat_line_2_en' => 'Goal: Reach 130% of last year\'s annual target',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($projects as $data) {
            HomeProject::updateOrCreate(
                ['title_ar' => $data['title_ar']],
                $data
            );
        }
    }
}
