<?php

use App\Http\Controllers\BackEnd\Auth\ForgotPasswordController;
use App\Http\Controllers\BackEnd\Auth\LoginController;
use App\Http\Controllers\BackEnd\Auth\RegisterController;
use App\Http\Controllers\BackEnd\Auth\ResetPasswordController;
use App\Http\Controllers\BackEnd\Banner\BannerController;
use App\Http\Controllers\BackEnd\Booking\BookingController;
use App\Http\Controllers\BackEnd\Category\CategoryController;
use App\Http\Controllers\BackEnd\ChooseUs\ChooseUsController;
use App\Http\Controllers\BackEnd\Comment\CommentController;
use App\Http\Controllers\BackEnd\CompanyLogo\CompanyLogoController;
use App\Http\Controllers\BackEnd\DashBoard\DashBoardController;
use App\Http\Controllers\BackEnd\Feature\FeatureController;
use App\Http\Controllers\BackEnd\Footer\FooterController;
use App\Http\Controllers\BackEnd\Header\HeaderController;
use App\Http\Controllers\BackEnd\NewsLetter\NewsletterController;
use App\Http\Controllers\BackEnd\Notification\NotificationController;
use App\Http\Controllers\BackEnd\Permission\PermissionController;
use App\Http\Controllers\BackEnd\Portfolio\PortfolioController;
use App\Http\Controllers\BackEnd\Profile\ProfileController;
use App\Http\Controllers\BackEnd\Project\ProjectController;
use App\Http\Controllers\BackEnd\Role\RoleController;
use App\Http\Controllers\BackEnd\Services\ServiceController;
use App\Http\Controllers\BackEnd\SiteSetting\SiteSettingController;
use App\Http\Controllers\BackEnd\User\UserController;
use App\Http\Controllers\FrontEnd\About\AboutController;
use App\Http\Controllers\FrontEnd\Contact\ContactController;
use App\Http\Controllers\FrontEnd\Faq\FaqController;
use App\Http\Controllers\FrontEnd\Home\HomeController;
use App\Http\Controllers\FrontEnd\Privacy\PrivacyController;
use App\Http\Controllers\FrontEnd\Services\ServicesController;
use App\Http\Controllers\FrontEnd\Team\TeamController;
use App\Http\Controllers\FrontEnd\Termes\TermesController;
use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});

Route::prefix('admin')->group(function () {
    // Register
    Route::get('/register', [RegisterController::class, 'show'])->name('admin.register');
    Route::post('/register', [RegisterController::class, 'store']);

    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'Adminlogin']);

    // logout 
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    // forget password 
    Route::get('/forgetpassword', [ForgotPasswordController::class, 'create'])->name('admin.forgetpassword');
    Route::post('/forgetpassword', [ForgotPasswordController::class, 'store'])->middleware('throttle:3,60');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store']);
});


Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function () {

        // dashboard 
        Route::get('/dashboard', [DashBoardController::class, 'dashBoard'])->name('admin.dashboard');

        // profile 
        Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile');
        Route::post('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');

        // Site Setting
        Route::get('/sitesettings', [SiteSettingController::class, 'siteSetting'])->name('admin.sitesetting');
        Route::post('/sitesetting/update', [SiteSettingController::class, 'siteSettingUpdate'])->name('admin.sitesetting.update');

        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        // header 
        Route::get('/headers', [HeaderController::class, 'index'])->name('headers.index');
        Route::post('/headers', [HeaderController::class, 'store'])->name('headers.store');

        // footer 
        Route::get('/footer', [FooterController::class, 'index'])->name('footer.index');
        Route::post('/footer', [FooterController::class, 'store'])->name('footer.store');

        // about 
        Route::get('/about-manage', [AboutController::class, 'index'])->name('about.index');
        Route::post('/about-manage', [AboutController::class, 'store'])->name('about.store');

        // Privacy 
        Route::get('/privacy-manage', [PrivacyController::class, 'index'])->name('privacy.index');
        Route::post('/privacy-manage', [PrivacyController::class, 'store'])->name('privacy.store');

        // Termes 
        Route::get('/termes-manage', [TermesController::class, 'index'])->name('termes.index');
        Route::post('/termes-manage', [TermesController::class, 'store'])->name('termes.store');

        // faq 
        Route::resource('faqs', FaqController::class);

        // team 
        Route::resource('teams', TeamController::class);

        // home Carousel 
        Route::resource('home-carousels', HomeController::class);

        // service 
        Route::resource('service-carousels', ServicesController::class);
        Route::resource('service', ServiceController::class);
        Route::resource('comments', CommentController::class);
        Route::resource('features', FeatureController::class);

        // banner bg image 
        Route::get('/banner', [BannerController::class, 'index'])->name('banner.index');
        Route::post('/banner', [BannerController::class, 'store'])->name('banner.store');

        // choose us 
        Route::resource('choose-us', ChooseUsController::class)->parameters(['choose-us' => 'chooseUs']);

        // projects 
        Route::resource('projects', ProjectController::class);

        // company logo 
        Route::resource('company-logos', CompanyLogoController::class)->parameters(['company-logos' => 'companyLogo']);

        // booking form 
        Route::get('notifications/{notification}', [BookingController::class, 'unreadshow'])->name('notifications.show');
        Route::get('booking/notifications', [BookingController::class, 'bookingNotification'])->name('booking.notification');
        Route::delete('bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

        // newsletter 
        Route::get('newsletter/list', [NewsletterController::class, 'newsletterList'])->name('newsletter.list');
        Route::delete('newsletter/{newsletter}', [NewsletterController::class, 'destroy'])->name('newsletter.destroy');

        // contact 
        Route::get('contact/list', [ContactController::class, 'contactList'])->name('contact.list');
        Route::delete('contact/{contact}', [ContactController::class, 'destroy'])->name('contact.destroy');

        // notification 
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');

        // category 
        Route::resource('categories', CategoryController::class);

        // portfolio 
        Route::resource('portfolios', PortfolioController::class);
        Route::delete('portfolio-image/{id}', [PortfolioController::class, 'deleteImage'])->name('portfolio.image.delete');
    });
});


// 3 way use permission 
// Route::get('/users')->middleware('permission:view users');
// v-if="$page.props.auth.permissions.includes('delete users')"
// if (!auth()->user()->can('delete users')) {
//     abort(403);
// }