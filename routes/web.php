<?php

use Illuminate\Support\Facades\Route;

// 🧭 Import controllers
use App\Http\Controllers\PublicDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminContentController;
use App\Http\Controllers\Admin\OfficialController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\Admin\GpsController;
use App\Http\Controllers\Api\GpsUpdateController;
use App\Http\Controllers\AmbulanceBillingController;
use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\Admin\MissionVisionController;
use App\Http\Controllers\Admin\AboutMdrrmoController;

/*
|--------------------------------------------------------------------------
| Web Routes for MDRRMO Project
|--------------------------------------------------------------------------
| This file handles all public and admin web routes.
| Note: This is only for local dev. Real API routes go in api.php.
*/

// 🌐 Public dashboard (landing page)
Route::get('/', [PublicDashboardController::class, 'index']);

// 🛡️ Authenticated admin dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// 📝 Admin content posting (carousel, mission, vision, about, etc.)
Route::prefix('admin/posting')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminContentController::class, 'showPostingPage'])->name('admin.posting');

    // Posting sections
    Route::post('/carousel', [CarouselController::class, 'store']);
    Route::post('/mission-vision', [MissionVisionController::class, 'store']);
    Route::post('/about', [AboutMdrrmoController::class, 'store']);
    Route::post('/officials', [OfficialController::class, 'store']);
    Route::post('/trainings', [TrainingController::class, 'store']);
});

// 🗺️ Admin GPS tracking page
Route::get('/admin/gps', [GpsController::class, 'index'])->name('admin.gps');

// 📱 Driver location sender page
Route::get('/driver/send-location', function () {
    return view('driver.send-location');
});

// 📍 Temporary location update route (local testing only)
Route::post('/update-location', [GpsUpdateController::class, 'update'])->name('update.location');

// 🧾 Ambulance Billing
Route::get('/billing/create', [AmbulanceBillingController::class, 'create']);
Route::post('/billing', [AmbulanceBillingController::class, 'store']);

// 🔐 Auth (login/register) routes
require __DIR__.'/auth.php';

Route::get('/admin/gps/data', function () {
    return response()->json(\App\Models\Ambulance::all());
})->name('admin.gps.data');

use App\Http\Controllers\Driver\Auth\LoginController;

Route::prefix('driver')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('driver.login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('driver.login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('driver.logout');

Route::middleware('auth.driver')->group(function () {
    Route::get('/send-location', function () {
        return view('driver.send-location');
    });
});

});


use App\Http\Controllers\Admin\DriverController;

Route::prefix('admin/drivers')->middleware(['auth'])->group(function () {
    Route::get('/', [DriverController::class, 'index'])->name('admin.drivers.index'); // show form + list
    Route::post('/store', [DriverController::class, 'store'])->name('admin.drivers.store');
});

use App\Http\Controllers\Admin\AmbulanceController;

Route::prefix('admin/ambulances')->middleware(['auth'])->group(function () {
    Route::get('/', [AmbulanceController::class, 'index'])->name('admin.ambulances.index');
    Route::post('/store', [AmbulanceController::class, 'store'])->name('admin.ambulances.store');
});
