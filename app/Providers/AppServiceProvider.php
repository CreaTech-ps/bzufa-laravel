<?php

namespace App\Providers;

use App\Models\SeoSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $helpers = base_path('app/Helpers/helpers.php');
        if (file_exists($helpers)) {
            require_once $helpers;
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // مشاركة إعدادات SEO مع layout الموقع الأمامي
        View::composer('website.layout', function ($view) {
            $view->with('seo', SeoSetting::get());
        });
    }
}
