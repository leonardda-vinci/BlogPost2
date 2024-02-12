<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');

    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::controller(BlogController::class)->prefix('blogs')->group(function () {
        Route::get('', 'index')->name('blogs');
        Route::get('create', 'create')->name('blogs.create');
        Route::post('store', 'store')->name('blogs.store');
        Route::get('show/{id}', 'show')->name('blogs.show');
        Route::get('edit/{id}', 'edit')->name('blogs.edit');
        Route::put('edit/{id}', 'update')->name('blogs.update');
        Route::delete('destroy/{id}', 'destroy')->name('blogs.destroy');
    });

    // Profile Routes
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    // Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

