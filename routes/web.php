<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cp\DashboardController;
use App\Http\Controllers\Cp\SiteSettingsController;
use App\Http\Controllers\Cp\NewsController;
use App\Http\Controllers\Cp\ScholarshipController;
use App\Http\Controllers\Cp\ScholarshipApplicationController;
use App\Http\Controllers\Cp\PartnerController;
use App\Http\Controllers\Cp\AboutController;
use App\Http\Controllers\Cp\TeamMemberController;
use App\Http\Controllers\Cp\HomePageController;
use App\Http\Controllers\Cp\HomeStatisticController;
use App\Http\Controllers\Cp\SuccessStoryController;
use App\Http\Controllers\Cp\KananiController;
use App\Http\Controllers\Cp\KananiGalleryItemController;
use App\Http\Controllers\Cp\TamkeenPartnershipController;
use App\Http\Controllers\Cp\EmpowermentRequestController;
use App\Http\Controllers\Cp\ParasolsController;
use App\Http\Controllers\Cp\ParasolsRegionController;
use App\Http\Controllers\Cp\ParasolsImageController;
use App\Http\Controllers\Cp\SeoSettingsController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\NewsController as WebsiteNewsController;
use App\Http\Controllers\Website\AboutController as WebsiteAboutController;
use App\Http\Controllers\Website\TeamController as WebsiteTeamController;
use App\Http\Controllers\Website\PartnerController as WebsitePartnerController;
use App\Http\Controllers\Website\ScholarshipController as WebsiteScholarshipController;
use App\Http\Controllers\Website\KananiController as WebsiteKananiController;
use App\Http\Controllers\Website\TamkeenController as WebsiteTamkeenController;
use App\Http\Controllers\Website\ParasolsController as WebsiteParasolsController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [WebsiteAboutController::class, 'index'])->name('about.index');
Route::get('/our-team', [WebsiteTeamController::class, 'index'])->name('team.index');
Route::get('/success-partners', [WebsitePartnerController::class, 'index'])->name('partners.index');
Route::get('/grants', [WebsiteScholarshipController::class, 'index'])->name('grants.index');
Route::get('/grants/{slug}/apply', [WebsiteScholarshipController::class, 'apply'])->name('grants.apply');
Route::post('/grants/{slug}/apply', [WebsiteScholarshipController::class, 'storeApplication'])->name('grants.apply.store');
Route::get('/grants/{slug}', [WebsiteScholarshipController::class, 'show'])->name('grants.show');
Route::get('/projects/kanani', [WebsiteKananiController::class, 'index'])->name('kanani.index');
Route::get('/projects/tamkeen', [WebsiteTamkeenController::class, 'index'])->name('tamkeen.index');
Route::get('/projects/parasols', [WebsiteParasolsController::class, 'index'])->name('parasols.index');
Route::get('/news', [WebsiteNewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [WebsiteNewsController::class, 'show'])->name('news.show');

Route::prefix('cp')->name('cp.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/site-settings', [SiteSettingsController::class, 'edit'])->name('site-settings.edit');
    Route::put('/site-settings', [SiteSettingsController::class, 'update'])->name('site-settings.update');
    Route::get('/seo-settings', [SeoSettingsController::class, 'edit'])->name('seo-settings.edit');
    Route::put('/seo-settings', [SeoSettingsController::class, 'update'])->name('seo-settings.update');
    Route::get('/home', [HomePageController::class, 'edit'])->name('home.edit');
    Route::put('/home', [HomePageController::class, 'update'])->name('home.update');
    Route::post('/home-statistics', [HomeStatisticController::class, 'store'])->name('home-statistics.store');
    Route::get('/home-statistics/{home_statistic}/edit', [HomeStatisticController::class, 'edit'])->name('home-statistics.edit');
    Route::put('/home-statistics/{home_statistic}', [HomeStatisticController::class, 'update'])->name('home-statistics.update');
    Route::delete('/home-statistics/{home_statistic}', [HomeStatisticController::class, 'destroy'])->name('home-statistics.destroy');
    Route::resource('news', NewsController::class)->names('news');
    Route::resource('scholarships', ScholarshipController::class)->names('scholarships');
    Route::get('/scholarship-applications', [ScholarshipApplicationController::class, 'index'])->name('scholarship-applications.index');
    Route::get('/scholarship-applications/{scholarship_application}/edit', [ScholarshipApplicationController::class, 'edit'])->name('scholarship-applications.edit');
    Route::put('/scholarship-applications/{scholarship_application}', [ScholarshipApplicationController::class, 'update'])->name('scholarship-applications.update');
    Route::resource('partners', PartnerController::class)->names('partners');
    Route::get('/about', [AboutController::class, 'edit'])->name('about.edit');
    Route::put('/about', [AboutController::class, 'update'])->name('about.update');
    Route::resource('team-members', TeamMemberController::class)->names('team-members');
    Route::resource('success-stories', SuccessStoryController::class)->names('success-stories');
    Route::get('/kanani', [KananiController::class, 'edit'])->name('kanani.edit');
    Route::put('/kanani', [KananiController::class, 'update'])->name('kanani.update');
    Route::resource('kanani-gallery', KananiGalleryItemController::class)->names('kanani.gallery');
    Route::resource('tamkeen/partnerships', TamkeenPartnershipController::class)->names('tamkeen.partnerships');
    Route::get('/tamkeen/empowerment-requests', [EmpowermentRequestController::class, 'index'])->name('empowerment-requests.index');
    Route::get('/tamkeen/empowerment-requests/{empowerment_request}/edit', [EmpowermentRequestController::class, 'edit'])->name('empowerment-requests.edit');
    Route::put('/tamkeen/empowerment-requests/{empowerment_request}', [EmpowermentRequestController::class, 'update'])->name('empowerment-requests.update');
    Route::get('/parasols', [ParasolsController::class, 'edit'])->name('parasols.edit');
    Route::put('/parasols', [ParasolsController::class, 'update'])->name('parasols.update');
    Route::prefix('parasols')->name('parasols.')->group(function () {
        Route::resource('regions', ParasolsRegionController::class)->names('regions');
        Route::resource('regions.images', ParasolsImageController::class)->names('regions.images')->scoped();
    });
});



Route::get('storage/{file}', function ($file) {
    $path = storage_path('app/public/' . $file);
    if (!is_file($path)) {
        abort(404);
    }
    return response()->file($path);
})->where('file', '.+');
