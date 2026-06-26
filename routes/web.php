<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FlightCheckoutController;
use App\Http\Controllers\FlightSearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyDetailController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/check', function(){
    return view('prototyping.INDEX');
});

Route::prefix('prototype')->group(function(){
    Route::get('/', function(){
        return view('prototyping.index');
    });
});

// home
// Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/testhome', [UserController::class, 'home2'])->name('homepage');

// accommodations
Route::get('/accommodations/{id}', [PropertyDetailController::class, 'showPropertyDetailDirect'])->name('properties.detail');

// flights
Route::get('/airlines', [AirlineController::class, 'index'])->name('index.airlines');
Route::get('/flights', [FlightSearchController::class, 'index'])->name('flights');
// request pembatalan penerbangan ke admin

// deals / promos
Route::get('/deals', [PromoController::class, 'index'])->name('deals');

    Route::get('/my-bookings', [UserController::class, 'myBookings'])->name('bookings.success');
    Route::get('/my-favorites', [UserController::class, 'renderFavorites'])->name('favorites');


// --- ROUTING SYSTEM CHECKOUT TIKET PESAWAT STAYGO ---
Route::middleware('auth')->group(function () {
    // Menampilkan halaman checkout flights
    Route::get('/checkout/flight', [FlightCheckoutController::class, 'showCheckout'])->name('checkout.flight');
    
    // Menerima submit form booking simpan database AJAX POST
    Route::post('/checkout/flight/store', [FlightCheckoutController::class, 'storeBooking'])->name('checkout.flight.store');
    
    Route::get('/booking/{id}', [BookingController::class, 'openBookingPage'])->name('booking.open');
    Route::post('/booking/store',[BookingController::class,'storeBooking'])->name('booking.store');
    Route::post('/booking/{id}/cancel-request', [UserController::class, 'requestCancellation'])->name('booking.cancel.request');

    // addToFav
    Route::post('/favorites/toggle', [UserController::class, 'addToFav'])->name('favorites.toggle');
    Route::post('/review/{propertyId}', [UserController::class, 'addReview'])->name('review.store');

    Route::post('/promo/apply',[PromoController::class,'apply'])
    ->name('promo.apply');
    // cancel flight
    Route::post('/flight-bookings/{id}/cancel', [\App\Http\Controllers\BookingController::class, 'requestFlightCancel'])->name('flight.cancel.request');

       Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');


    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});

// Contoh dummy rute penampung halaman sukses invoice tanda terima (receipt) agar tidak crash
Route::get('/booking/receipt/{code}', function($code) {
    return 'Halaman Sukses Booking Tiket Pesawat! Kode Booking Invoice Anda: ' . $code;
})->name('booking.receipt');

// Route::get('/airlines', [])

// Route::get('/airlines', [AirlineController::class, 'index'])->name('index.airlines');


// ROOT
Route::get('/', [UserController::class, 'home2'])->name('home');



// admin routes->admin middleware only
Route::get('/admin/login', function(){return view('dummy_pages.admins.login');})->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'AdminLogin'])->name('admin.login.submit');
// Route::get('/admin/dashboard', [AdminController::class, 'openDashboard'])->name('admin.dashboard');

Route::middleware(['isAdmin'])->prefix('admin')->group(function () {
    // Halaman Utama Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'openDashboard'])->name('admin.dashboard');
    Route::get('/cancel-requests', [AdminController::class, 'openCancelRequests'])
    ->name('admin.cancel.requests');

Route::patch('/cancel-requests/{id}/approve', [AdminController::class, 'approveCancelRequest'])->name('admin.cancel.approve');
    Route::patch('/cancel-requests/{id}/reject', [AdminController::class, 'rejectCancelRequest'])->name('admin.cancel.reject');
 
    Route::get('/promos', [AdminController::class, 'openPromos'])->name('admin.promos');
    Route::get('/users', [AdminController::class, 'openUsers'])->name('admin.users');
    Route::get('/reservations', [AdminController::class, 'openReserv'])->name('admin.reservations');

    Route::post('/promo-create', [AdminController::class, 'createPromo'])->name('admin.promo.create');
    Route::put('/promos/update/{id}', [AdminController::class, 'editPromo'])->name('admin.promos.update');
Route::delete('/promos/delete/{id}', [AdminController::class, 'deletePromo'])->name('admin.promos.destroy');
    
    Route::get('/reservations/{id}', [AdminController::class, 'viewReserv'])->name('admin.reservations.show');
Route::post('/reservations/update/{id}', [AdminController::class, 'editReserv'])->name('admin.reservations.update');
Route::delete('/reservations/delete/{id}', [AdminController::class, 'deleteReserv'])->name('admin.reservations.destroy');

Route::get('/flight-bookings/{id}', [AdminController::class, 'viewBooking'])->name('admin.flight-bookings.show');
Route::delete('/flight-bookings/delete/{id}', [AdminController::class, 'deleteBooking'])->name('admin.flight-bookings.destroy');

    Route::get('/users/{id}', [AdminController::class, 'viewUser'])->name('admin.users.show');
    Route::put('/users/update/{id}', [AdminController::class, 'editUserStatus'])->name('admin.users.update');
    Route::delete('/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.destroy');
    Route::post('/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
});
// user routes
// Route::get('/', function(){
//     return view('dummy_pages.home');
// })->name('home');

// user routes
Route::get('/register', function(){
    return view('register');
})->name('register.form');
Route::post('/register', [UserController::class, 'register'])->name('register.submit');
Route::get('/login', [UserController::class, 'openLogin'])->name('login');
Route::post('/login', [UserController::class, 'login'])
    ->name('login.submit');
Route::get('/accomodations', [SearchController::class, 'openAccomodationPage'])->name('accomodations.open');

// Route::get('/search-accomodations-home', [SearchController::class, 'searchAccomodations'])->name('accomodations.search.home');

Route::get('/search-accomodations', [SearchController::class, 'searchAccomodations'])->name('accomodations.search');
// Route::get('/accomodation-result', [SearchController::class, 'showAccomodationResults'])->name('accomodations.result');
Route::get('/properties/{id}', [SearchController::class, 'openPropertyDetail'])
    ->name('property.detail');


// butuh user middleware:

