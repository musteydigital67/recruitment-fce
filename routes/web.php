<?php

use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PositionController as AdminPositionController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [PositionController::class, 'index'])->name('positions.index');
Route::get('/positions/{position}', [PositionController::class, 'show'])->name('positions.show');
Route::get('/positions/{position}/apply', [ApplicationController::class, 'create'])->name('applications.create');
Route::post('/positions/{position}/apply', [ApplicationController::class, 'store'])->name('applications.store');

// Admin auth
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login')->middleware('guest');
    Route::post('/login', [AdminAuthController::class, 'login'])->middleware('guest');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('positions', AdminPositionController::class)->except(['show']);

        Route::get('/applications', [AdminApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [AdminApplicationController::class, 'show'])->name('applications.show');
        Route::patch('/applications/{application}/status', [AdminApplicationController::class, 'updateStatus'])->name('applications.status');
        Route::get('/applications/{application}/download/{type}', [AdminApplicationController::class, 'download'])->name('applications.download');
    });
});
