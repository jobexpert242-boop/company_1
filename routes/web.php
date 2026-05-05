<?php

use App\Http\Controllers\BackEnd\Booking\BookingController;
use App\Http\Controllers\BackEnd\NewsLetter\NewsletterController;
use App\Http\Controllers\FrontEnd\About\AboutController;
use App\Http\Controllers\FrontEnd\Contact\ContactController;
use App\Http\Controllers\FrontEnd\Faq\FaqController;
use App\Http\Controllers\FrontEnd\Home\HomeController;
use App\Http\Controllers\FrontEnd\Portfolio\PortfolioController;
use App\Http\Controllers\FrontEnd\Privacy\PrivacyController;
use App\Http\Controllers\FrontEnd\Services\ServicesController;
use App\Http\Controllers\FrontEnd\Team\TeamController;
use App\Http\Controllers\FrontEnd\Termes\TermesController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


// include route
require __DIR__ . '/admin.php';

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/about', [AboutController::class, 'about'])->name('about');
Route::get('/team', [TeamController::class, 'team'])->name('team');
Route::get('/team/{id}', [TeamController::class, 'teamDetails'])->name('team.details');
Route::get('/services', [ServicesController::class, 'services'])->name('services');
Route::get('/services/{slug}', [ServicesController::class, 'serviceDetails'])->name('services.details');
Route::get('/portfolio', [PortfolioController::class, 'portfolio'])->name('portfolio');
Route::get('/portfolio/{slug}', [PortfolioController::class, 'portfolioDetails'])->name('portfolio.details');
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::get('/faq', [FaqController::class, 'faq'])->name('faq');
Route::get('/privacy-policy', [PrivacyController::class, 'privacy'])->name('privacy-policy');
Route::get('/termes&conditions', [TermesController::class, 'termes'])->name('termes&conditions');

// booking 
Route::post('bookingform', [BookingController::class, 'store'])->name('booking.store');

// newsletter 
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

// contact 
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


// storage link 
Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created';
});
