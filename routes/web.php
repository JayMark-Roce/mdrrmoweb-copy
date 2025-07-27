<?php

use Illuminate\Support\Facades\Route;

<<<<<<< HEAD
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [App\Http\Controllers\PublicDashboardController::class, 'index']);


use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

use App\Http\Controllers\AdminContentController;

Route::prefix('admin/posting')->group(function () {
    Route::get('/', [AdminContentController::class, 'showPostingPage'])->name('admin.posting');


    Route::post('/carousel', [AdminContentController::class, 'storeCarousel']);
    Route::post('/mission-vision', [AdminContentController::class, 'storeMissionVision']);
    Route::post('/about', [AdminContentController::class, 'storeAbout']);
});
use App\Http\Controllers\Admin\OfficialController;

Route::post('/admin/posting/officials', [OfficialController::class, 'store'])->middleware(['auth']);

use App\Http\Controllers\TrainingController;

Route::post('/admin/posting/trainings', [TrainingController::class, 'store'])->middleware(['auth']);


require __DIR__.'/auth.php';


use App\Http\Controllers\AmbulanceBillingController;

Route::get('/billing/create', [AmbulanceBillingController::class, 'create']);
Route::post('/billing', [AmbulanceBillingController::class, 'store']);

use App\Http\Controllers\PublicDashboardController;

Route::get('/', [PublicDashboardController::class, 'index']);


=======
// 🧭 Import controllers
use App\Http\Controllers\PublicDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminContentController;
use App\Http\Controllers\Admin\OfficialController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\Admin\GpsController;
use App\Http\Controllers\Api\GpsUpdateController;
use App\Http\Controllers\AmbulanceBillingController;
>>>>>>> 887899e7221396f620d0d6dad872e632d494197b
use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\Admin\MissionVisionController;
use App\Http\Controllers\Admin\AboutMdrrmoController;

<<<<<<< HEAD
// Admin Posting Routes
Route::prefix('admin/posting')->middleware(['auth'])->group(function () {
    Route::post('/carousel', [CarouselController::class, 'store']);
    Route::post('/mission-vision', [MissionVisionController::class, 'store']);
    Route::post('/about', [AboutMdrrmoController::class, 'store']);
});
=======
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
        $driver = auth('driver')->user();
        return view('driver.send-location', [
            'ambulanceId' => $driver->ambulance_id ?? null,
        ]);
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


use Illuminate\Http\Request;

// POST /admin/ambulance/{id}/set-destination
Route::post('/admin/ambulance/{id}/set-destination', function ($id, Illuminate\Http\Request $request) {
    $amb = \App\Models\Ambulance::findOrFail($id);
    $amb->destination_latitude = $request->latitude;
    $amb->destination_longitude = $request->longitude;
    $amb->status = 'Out';
    $amb->save();

    return response()->json(['success' => true]);
});

// POST /admin/ambulance/{id}/clear-destination
Route::post('/admin/ambulance/{id}/clear-destination', function ($id) {
    $amb = \App\Models\Ambulance::findOrFail($id);
    $amb->destination_latitude = null;
    $amb->destination_longitude = null;
    $amb->status = 'Available';
    $amb->save();

    return response()->json(['success' => true]);
});

Route::post('/admin/ambulance/{id}/set-destination', [AmbulanceController::class, 'setDestination']);

Route::post('/admin/gps/set-destination', [GpsController::class, 'setDestination'])->name('admin.gps.set-destination');


Route::get('/check-db', function () {
    return DB::connection()->getDatabaseName();
});

Route::post('/admin/ambulance/{id}/clear-destination', [AmbulanceController::class, 'clearDestination']);

// Get destination for ambulance
Route::get('/driver/ambulance/{id}/destination', function ($id) {
    $amb = \App\Models\Ambulance::findOrFail($id);
    return response()->json([
        'destination_latitude' => $amb->destination_latitude,
        'destination_longitude' => $amb->destination_longitude
    ]);
});

// Arrived — clear destination + set status = Available
Route::post('/driver/ambulance/{id}/arrived', function ($id) {
    $ambulance = \App\Models\Ambulance::findOrFail($id);
    $ambulance->destination_latitude = null;
    $ambulance->destination_longitude = null;
    $ambulance->status = 'Available';
    $ambulance->destination_updated_at = now();
    $ambulance->save();

    return response()->json(['success' => true]);
});

>>>>>>> 887899e7221396f620d0d6dad872e632d494197b
