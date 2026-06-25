<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PropertyDetailController;
use App\Http\Controllers\UserController;


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

Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/testhome', [UserController::class, 'home2'])->name('homepage');
Route::get('/accommodations/{id}', [PropertyDetailController::class, 'show'])->name('properties.detail');
// Route::get('/airlines', [])

Route::get('/airlines', [AirlineController::class, 'index'])->name('index.airlines');

// admin routes
Route::get('/admin/login', function(){
    return view('dummy_pages.admins.login');
})->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'AdminLogin'])->name('admin.login.submit');
Route::get('/admin/dashboard', [AdminController::class, 'openDashboard'])->name('admin.dashboard');

// user routes
// Route::get('/', function(){
//     return view('dummy_pages.home');
// })->name('home');
Route::get('/register', function(){
    return view('dummy_pages.users.registration');
})->name('register.form');
Route::post('/register', [UserController::class, 'register'])->name('register.submit');
Route::get('/login', [UserController::class, 'openLogin'])->name('login.form');
Route::post('/login', [UserController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [UserController::class, 'logout'])
    ->name('logout');