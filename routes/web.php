<?php

use Illuminate\Support\Facades\Route;

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


use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\Admin\MissionVisionController;
use App\Http\Controllers\Admin\AboutMdrrmoController;

// Admin Posting Routes
Route::prefix('admin/posting')->middleware(['auth'])->group(function () {
    Route::post('/carousel', [CarouselController::class, 'store']);
    Route::post('/mission-vision', [MissionVisionController::class, 'store']);
    Route::post('/about', [AboutMdrrmoController::class, 'store']);
});
