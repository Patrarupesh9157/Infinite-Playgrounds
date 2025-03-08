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
        // Route::resource('products', ProductController::class);
        // Route::prefix('category')->name('category.')->group(function () {
        //     // Resource routes for each category
        //     Route::resource('concept', ConceptController::class);
        //     Route::resource('yarn', YarnController::class);
        //     Route::resource('area', AreaController::class);
        //     Route::resource('fabric', FabricController::class);
        //     Route::resource('technically-concept', TechnicallyConceptController::class);
        //     Route::resource('panna', PannaController::class);
        //     Route::resource('usein', UseInController::class);
        // });
    });
});
