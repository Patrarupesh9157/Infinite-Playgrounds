<?php


use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController; // Make sure to import the LoginController

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Login route for admin
    // Admin Category Routes with Authentication Middleware

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::middleware(['auth:admin'])->group(function () {
        Route::resource('games', GameController::class);
        Route::get('get-admin-count-data', [HomeController::class, 'getAdminCountData'])->name('dashboard.getAdminCountData');
    });
});
