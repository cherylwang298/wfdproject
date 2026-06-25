<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FlightSearchController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\PropertyDetailController;
use App\Http\Controllers\PropertyController;
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
Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/testhome', [UserController::class, 'home2'])->name('homepage');

// accommodations
Route::get('/accommodations/{id}', [PropertyDetailController::class, 'show'])->name('properties.detail');

// flights
Route::get('/airlines', [AirlineController::class, 'index'])->name('index.airlines');
Route::get('/flights', [FlightSearchController::class, 'index'])->name('flights');

// deals / promos
Route::get('/deals', [PromoController::class, 'index'])->name('deals');

// Route::get('/airlines', [])

// Route::get('/airlines', [AirlineController::class, 'index'])->name('index.airlines');


// ROOT
Route::get('/', [UserController::class, 'home'])->name('home');



// admin routes->admin middleware only
Route::get('/admin/login', function(){
    return view('dummy_pages.admins.login');
})->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'AdminLogin'])->name('admin.login.submit');
Route::get('/admin/dashboard', [AdminController::class, 'openDashboard'])->name('admin.dashboard');

// user routes
// Route::get('/', function(){
//     return view('dummy_pages.home');
// })->name('home');

// user routes
Route::get('/register', function(){
    return view('dummy_pages.users.registration');
})->name('register.form');
Route::post('/register', [UserController::class, 'register'])->name('register.submit');
Route::get('/login', [UserController::class, 'openLogin'])->name('login.form');
Route::post('/login', [UserController::class, 'login'])
    ->name('login.submit');
Route::get('/accomodations', [SearchController::class, 'openAccomodationPage'])->name('accomodations.open');

Route::get('/search-accomodations', [SearchController::class, 'searchAccomodations'])->name('accomodations.search');
// Route::get('/accomodation-result', [SearchController::class, 'showAccomodationResults'])->name('accomodations.result');
Route::get('/properties/{id}', [SearchController::class, 'openPropertyDetail'])
    ->name('property.detail');


// butuh user middleware:


Route::post('/logout', [UserController::class, 'logout'])
    ->name('logout');