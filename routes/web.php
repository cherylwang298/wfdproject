<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/check', function(){
    return view('prototyping.INDEX');
});

Route::prefix('prototype')->group(function(){
    Route::get('/', function(){
        return view('prototyping.index');
    });
});

Route::get('/properties', [PropertyController::class, 'index'])->name('index.properties');
// Route::get('/airlines', [])

Route::get('/airlines', [AirlineController::class, 'index'])->name('index.airlines');

Route::get('/admin/login', function(){
    return view('dummy_pages.admins.login');
})->name('admin.login');

Route::post('/admin/login', [AuthController::class, 'AdminLogin'])->name('admin.login.submit');

Route::get('/admin/dashboard', [AdminController::class, 'openDashboard'])->name('admin.dashboard');