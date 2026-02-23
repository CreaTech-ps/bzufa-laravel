<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
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
use App\Http\Controllers\Website\PageController as WebsitePageController;
use App\Http\Controllers\Website\VolunteerController as WebsiteVolunteerController;
use App\Http\Controllers\Cp\VolunteerDepartmentController;
use App\Http\Controllers\Website\TamkeenPartnershipController as WebsiteTamkeenPartnershipController;
use App\Http\Controllers\Website\SitemapController;
use App\Http\Controllers\Website\RobotsController;
use App\Http\Controllers\Cp\VolunteerApplicationController;
use App\Http\Controllers\Cp\TamkeenPartnershipRequestController;
use App\Http\Controllers\Cp\PartnershipRequestController;
use App\Http\Controllers\Cp\HomeProjectController;
use App\Http\Controllers\Cp\SiteTextController;

// مسارات الموقع الأمامي: تسجيل لكل من /en و / (عربي بدون بادئة) ليعمل كلا اللغتين
$localizedMiddleware = ['locale.from.url', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'];
$registerLocalizedRoutes = function () use ($localizedMiddleware) {
    Route::middleware($localizedMiddleware)->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/about-us', [WebsiteAboutController::class, 'index'])->name('about.index');
        Route::get('/our-team', [WebsiteTeamController::class, 'index'])->name('team.index');
        Route::get('/success-partners', [WebsitePartnerController::class, 'index'])->name('partners.index');
        Route::post('/success-partners/partnership-request', [WebsitePartnerController::class, 'storePartnershipRequest'])->name('partners.partnership-request.store');
        Route::get('/grants', [WebsiteScholarshipController::class, 'index'])->name('grants.index');
        Route::get('/grants/{slug}/apply', [WebsiteScholarshipController::class, 'apply'])->name('grants.apply');
        Route::post('/grants/{slug}/apply', [WebsiteScholarshipController::class, 'storeApplication'])->name('grants.apply.store');
        Route::get('/grants/{slug}', [WebsiteScholarshipController::class, 'show'])->name('grants.show');
        Route::get('/projects/kanani', [WebsiteKananiController::class, 'index'])->name('kanani.index');
        Route::get('/projects/tamkeen', [WebsiteTamkeenController::class, 'index'])->name('tamkeen.index');
        Route::get('/projects/parasols', [WebsiteParasolsController::class, 'index'])->name('parasols.index');
        Route::get('/projects/parasols/spaces', [WebsiteParasolsController::class, 'spaces'])->name('parasols.spaces');
        Route::get('/news', [WebsiteNewsController::class, 'index'])->name('news.index');
        Route::get('/news/{slug}', [WebsiteNewsController::class, 'show'])->name('news.show');
        Route::get('/privacy-policy', [WebsitePageController::class, 'privacy'])->name('privacy');
        Route::get('/terms-of-use', [WebsitePageController::class, 'terms'])->name('terms');
        Route::get('/volunteer/departments', [WebsiteVolunteerController::class, 'getDepartments'])->name('volunteer.departments');
        Route::post('/volunteer', [WebsiteVolunteerController::class, 'store'])->name('volunteer.store');
        Route::get('/tamkeen/partnerships/filter', [WebsiteTamkeenPartnershipController::class, 'filter'])->name('tamkeen.partnerships.filter');
        Route::post('/tamkeen/partnerships', [WebsiteTamkeenPartnershipController::class, 'store'])->name('tamkeen.partnerships.store');
        Route::post('/newsletter/subscribe', [\App\Http\Controllers\Website\NewsletterSubscriptionController::class, 'store'])->name('newsletter.subscribe');
        Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
        Route::get('/robots.txt', [RobotsController::class, 'index'])->name('robots');
    });
};
Route::prefix('en')->group($registerLocalizedRoutes);
// تسجيل /ar أيضاً ثم الحزمة توجّه تلقائياً إلى / (لأن hideDefaultLocaleInURL = true)
Route::prefix('ar')->group($registerLocalizedRoutes);
Route::prefix('')->group($registerLocalizedRoutes);

Route::get('/cp/login', [\App\Http\Controllers\Cp\AuthController::class, 'showLoginForm'])->name('cp.login');
Route::post('/cp/login', [\App\Http\Controllers\Cp\AuthController::class, 'login']);
Route::match(['get', 'post'], '/cp/logout', [\App\Http\Controllers\Cp\AuthController::class, 'logout'])->name('cp.logout');

Route::prefix('cp')->name('cp.')->middleware(['cp.auth', 'cp.check'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/site-settings', [SiteSettingsController::class, 'edit'])->name('site-settings.edit');
    Route::put('/site-settings', [SiteSettingsController::class, 'update'])->name('site-settings.update');
    Route::get('/seo-settings', [SeoSettingsController::class, 'edit'])->name('seo-settings.edit');
    Route::get('/site-texts', [SiteTextController::class, 'index'])->name('site-texts.index');
    Route::put('/site-texts', [SiteTextController::class, 'update'])->name('site-texts.update');
    Route::put('/seo-settings', [SeoSettingsController::class, 'update'])->name('seo-settings.update');
    Route::get('/home', [HomePageController::class, 'edit'])->name('home.edit');
    Route::put('/home', [HomePageController::class, 'update'])->name('home.update');
    Route::post('/home-statistics', [HomeStatisticController::class, 'store'])->name('home-statistics.store');
    Route::get('/home-statistics/{home_statistic}/edit', [HomeStatisticController::class, 'edit'])->name('home-statistics.edit');
    Route::put('/home-statistics/{home_statistic}', [HomeStatisticController::class, 'update'])->name('home-statistics.update');
    Route::delete('/home-statistics/{home_statistic}', [HomeStatisticController::class, 'destroy'])->name('home-statistics.destroy');
    Route::resource('home-projects', HomeProjectController::class)->names('home-projects');
    Route::resource('news', NewsController::class)->names('news');
    Route::resource('scholarships', ScholarshipController::class)->names('scholarships');
    Route::get('/scholarship-applications', [ScholarshipApplicationController::class, 'index'])->name('scholarship-applications.index');
    Route::get('/scholarship-applications/{scholarship_application}/edit', [ScholarshipApplicationController::class, 'edit'])->name('scholarship-applications.edit');
    Route::put('/scholarship-applications/{scholarship_application}', [ScholarshipApplicationController::class, 'update'])->name('scholarship-applications.update');
    Route::resource('partners', PartnerController::class)->names('partners');
    Route::get('/partnership-requests', [PartnershipRequestController::class, 'index'])->name('partnership-requests.index');
    Route::get('/partnership-requests/{partnership_request}/edit', [PartnershipRequestController::class, 'edit'])->name('partnership-requests.edit');
    Route::put('/partnership-requests/{partnership_request}', [PartnershipRequestController::class, 'update'])->name('partnership-requests.update');
    Route::get('/about', [AboutController::class, 'edit'])->name('about.edit');
    Route::put('/about', [AboutController::class, 'update'])->name('about.update');
    Route::resource('team-members', TeamMemberController::class)->names('team-members');
    Route::resource('success-stories', SuccessStoryController::class)->names('success-stories');
    Route::get('/kanani', [KananiController::class, 'edit'])->name('kanani.edit');
    Route::put('/kanani', [KananiController::class, 'update'])->name('kanani.update');
    Route::resource('kanani-gallery', KananiGalleryItemController::class)->names('kanani.gallery');
    Route::resource('tamkeen/partnerships', TamkeenPartnershipController::class)->names('tamkeen.partnerships');
    Route::get('/tamkeen/settings', [\App\Http\Controllers\Cp\TamkeenSettingController::class, 'edit'])->name('tamkeen.settings.edit');
    Route::put('/tamkeen/settings', [\App\Http\Controllers\Cp\TamkeenSettingController::class, 'update'])->name('tamkeen.settings.update');
    Route::get('/tamkeen/empowerment-requests', [EmpowermentRequestController::class, 'index'])->name('empowerment-requests.index');
    Route::get('/tamkeen/empowerment-requests/{empowerment_request}/edit', [EmpowermentRequestController::class, 'edit'])->name('empowerment-requests.edit');
    Route::put('/tamkeen/empowerment-requests/{empowerment_request}', [EmpowermentRequestController::class, 'update'])->name('empowerment-requests.update');
    Route::get('/parasols', [ParasolsController::class, 'edit'])->name('parasols.edit');
    Route::put('/parasols', [ParasolsController::class, 'update'])->name('parasols.update');
    Route::prefix('parasols')->name('parasols.')->group(function () {
        Route::resource('regions', ParasolsRegionController::class)->names('regions');
        Route::resource('regions.images', ParasolsImageController::class)->names('regions.images')->scoped();
    });
    Route::resource('volunteer-departments', VolunteerDepartmentController::class)->names('volunteer-departments');
    Route::get('/volunteer-applications', [VolunteerApplicationController::class, 'index'])->name('volunteer-applications.index');
    Route::get('/volunteer-applications/{volunteer_application}/edit', [VolunteerApplicationController::class, 'edit'])->name('volunteer-applications.edit');
    Route::put('/volunteer-applications/{volunteer_application}', [VolunteerApplicationController::class, 'update'])->name('volunteer-applications.update');
    Route::get('/tamkeen/partnership-requests', [TamkeenPartnershipRequestController::class, 'index'])->name('tamkeen.partnership-requests.index');
    Route::get('/tamkeen/partnership-requests/{tamkeen_partnership_request}/edit', [TamkeenPartnershipRequestController::class, 'edit'])->name('tamkeen.partnership-requests.edit');
    Route::put('/tamkeen/partnership-requests/{tamkeen_partnership_request}', [TamkeenPartnershipRequestController::class, 'update'])->name('tamkeen.partnership-requests.update');
    Route::get('/newsletter', [\App\Http\Controllers\Cp\NewsletterController::class, 'index'])->name('newsletter.index');
    Route::get('/newsletter/broadcast', [\App\Http\Controllers\Cp\NewsletterController::class, 'broadcast'])->name('newsletter.broadcast');
    Route::post('/newsletter/broadcast', [\App\Http\Controllers\Cp\NewsletterController::class, 'sendBroadcast'])->name('newsletter.send');
    Route::delete('/newsletter/subscribers/{subscriber}', [\App\Http\Controllers\Cp\NewsletterController::class, 'destroy'])->name('newsletter.destroy');

    // المالية والتبرعات
    Route::get('/financial', [\App\Http\Controllers\Cp\FinancialDashboardController::class, 'index'])->name('financial.index');
    Route::resource('donations', \App\Http\Controllers\Cp\DonationController::class)->names('donations');
    Route::post('/donations/{donation}/approve', [\App\Http\Controllers\Cp\DonationController::class, 'approve'])->name('donations.approve');
    Route::post('/donations/{donation}/reject', [\App\Http\Controllers\Cp\DonationController::class, 'reject'])->name('donations.reject');
    Route::resource('financial-transactions', \App\Http\Controllers\Cp\FinancialTransactionController::class)->names('financial-transactions')->except(['destroy']);
    Route::post('/financial-transactions/{financial_transaction}/submit', [\App\Http\Controllers\Cp\FinancialTransactionController::class, 'submitForReview'])->name('financial-transactions.submit');
    Route::post('/financial-transactions/{financial_transaction}/approve', [\App\Http\Controllers\Cp\FinancialTransactionController::class, 'approve'])->name('financial-transactions.approve');
    Route::post('/financial-transactions/{financial_transaction}/reject', [\App\Http\Controllers\Cp\FinancialTransactionController::class, 'reject'])->name('financial-transactions.reject');
    Route::post('/financial-transactions/{financial_transaction}/complete', [\App\Http\Controllers\Cp\FinancialTransactionController::class, 'markCompleted'])->name('financial-transactions.complete');
    Route::get('/financial/reports', [\App\Http\Controllers\Cp\FinancialReportController::class, 'index'])->name('financial.reports.index');
    Route::get('/financial/reports/donations', [\App\Http\Controllers\Cp\FinancialReportController::class, 'donations'])->name('financial.reports.donations');
    Route::get('/financial/reports/expenses', [\App\Http\Controllers\Cp\FinancialReportController::class, 'expenses'])->name('financial.reports.expenses');
    Route::get('/financial/reports/cash-flow', [\App\Http\Controllers\Cp\FinancialReportController::class, 'cashFlow'])->name('financial.reports.cash-flow');

    // المستخدمين والصلاحيات (للمدير فقط)
    Route::resource('users', \App\Http\Controllers\Cp\UserController::class)->names('users')->except(['show']);
    Route::resource('roles', \App\Http\Controllers\Cp\RoleController::class)->names('roles')->except(['show']);
});

Route::get('storage/{file}', function ($file) {
    $path = storage_path('app/public/' . $file);
    if (!is_file($path)) {
        abort(404);
    }
    return response()->file($path);
})->where('file', '.+');
