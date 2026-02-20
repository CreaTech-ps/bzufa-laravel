<?php

namespace App\Providers;

use App\Models\SeoSetting;
use App\Models\SiteSetting;
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
        View::composer('website.partials.social-bar', function ($view) {
            $view->with('settings', SiteSetting::get());
        });
        // مشاركة إعدادات SEO مع layout الموقع الأمامي
        View::composer('website.layout', function ($view) {
            $view->with('seo', SeoSetting::get());
        });
    }
}
