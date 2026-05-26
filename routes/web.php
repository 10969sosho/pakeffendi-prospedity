<?php

use App\Http\Controllers\Admin\AboutSettingController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdvisorGuideController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BankAccountController;
use App\Http\Controllers\Admin\ContactSettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeaturedPropertyController;
use App\Http\Controllers\Admin\HomeSettingController;
use App\Http\Controllers\Admin\InquiryCategoryController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\OurServiceController;
use App\Http\Controllers\Admin\PicProfileController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\PropertyTypeController;
use App\Http\Controllers\Admin\SalesOrderController;
use App\Http\Controllers\Admin\ServicePackageController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Public\AboutUsController;
use App\Http\Controllers\Public\BaliGuideController;
use App\Http\Controllers\Public\ContactUsController;
use App\Http\Controllers\Public\PropertyController as PublicPropertyController;
use App\Http\Controllers\Public\SalesOrderController as PublicSalesOrderController;
use App\Http\Controllers\Public\ServicePackageController as PublicServicePackageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Language switcher
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Global login alias so auth middleware can redirect to a valid route('login')
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Guest/Public routes
Route::get('/', [PublicPropertyController::class, 'index'])->name('home');
Route::get('/featured-properties', [PublicPropertyController::class, 'featured'])->name('featured-properties');
Route::get('/property/{slug}', [PublicPropertyController::class, 'show'])->name('property.show');
Route::get('/successful-properties', [PublicPropertyController::class, 'successfulProperties'])->name('successful-properties');

// Our Services / About Us routes
Route::get('/our-services', [PublicServicePackageController::class, 'index'])->name('our-services');
Route::get('/our-services/{servicePackage}/order', [PublicSalesOrderController::class, 'create'])->name('our-services.order.create');
Route::post('/our-services/{servicePackage}/order', [PublicSalesOrderController::class, 'store'])->name('our-services.order.store');
Route::get('/our-services/order/{salesOrder}', [PublicSalesOrderController::class, 'show'])->name('our-services.order.show');
Route::get('/our-services/order/{salesOrder}/invoice', [PublicSalesOrderController::class, 'invoice'])->name('our-services.order.invoice');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us');

// Advisor Guide route
Route::get('/advisor-guide', [BaliGuideController::class, 'index'])->name('advisor-guide');
Route::get('/advisor-guide/{advisorGuide}', [BaliGuideController::class, 'show'])->name('advisor-guide.show');

// Contact Us routes
Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact-us');
Route::post('/contact-us', [ContactUsController::class, 'store'])->name('contact-us.store');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth routes (no middleware)
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CMS - Home settings
        Route::get('home-settings', [HomeSettingController::class, 'edit'])->name('home-settings.edit');
        Route::post('home-settings', [HomeSettingController::class, 'update'])->name('home-settings.update');

        // CMS - Contact settings
        Route::get('contact-settings', [ContactSettingController::class, 'edit'])->name('contact-settings.edit');
        Route::post('contact-settings', [ContactSettingController::class, 'update'])->name('contact-settings.update');

        // Inquiry Categories
        Route::post('inquiry-categories', [InquiryCategoryController::class, 'store'])->name('inquiry-categories.store');
        Route::delete('inquiry-categories/{inquiryCategory}', [InquiryCategoryController::class, 'destroy'])->name('inquiry-categories.destroy');

        // CMS - About settings
        Route::get('about-settings', [AboutSettingController::class, 'edit'])->name('about-settings.edit');
        Route::post('about-settings', [AboutSettingController::class, 'update'])->name('about-settings.update');

        // Transaction Management
        Route::get('transactions', [PropertyController::class, 'transactionIndex'])->name('transactions.index');
        Route::post('transactions/extend', [PropertyController::class, 'extendTransactionValidity'])->name('transactions.extend');

        Route::resource('properties', PropertyController::class);
        Route::post('properties/{id}/delete-photo', [PropertyController::class, 'deletePhoto'])->name('properties.delete-photo');
        Route::post('properties/{id}/set-cover-photo', [PropertyController::class, 'setCoverPhoto'])->name('properties.set-cover-photo');
        Route::get('properties-successful', [PropertyController::class, 'successfulProperties'])->name('properties.successful');

        // Featured Properties
        Route::get('featured-properties', [FeaturedPropertyController::class, 'index'])->name('featured-properties.index');
        Route::post('featured-properties/update-order', [FeaturedPropertyController::class, 'updateOrder'])->name('featured-properties.update-order');
        Route::delete('featured-properties/{property}', [FeaturedPropertyController::class, 'destroy'])->name('featured-properties.destroy');

        // Our Services
        Route::resource('our-services', OurServiceController::class)
            ->parameters(['our-services' => 'ourService']);
        Route::post('our-services/update-order', [OurServiceController::class, 'updateOrder'])->name('our-services.update-order');

        // Service Packages
        Route::resource('service-packages', ServicePackageController::class)
            ->parameters(['service-packages' => 'servicePackage']);

        // Sales Orders
        Route::get('sales-orders', [SalesOrderController::class, 'index'])->name('sales-orders.index');

        Route::resource('bank-accounts', BankAccountController::class)->except(['show']);
        Route::post('bank-accounts/{bankAccount}/activate', [BankAccountController::class, 'activate'])->name('bank-accounts.activate');

        // Tags
        Route::resource('tags', TagController::class);

        // Property Types
        Route::resource('property-types', PropertyTypeController::class);

        Route::resource('inquiries', InquiryController::class);
        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

        // CMS - Advisor Guide posts
        Route::resource('advisor-guides', AdvisorGuideController::class);

        // PIC Profiles
        Route::resource('pic-profiles', PicProfileController::class);

        // User management (only for superadmin)
        Route::resource('users', UserController::class);
    });
});
