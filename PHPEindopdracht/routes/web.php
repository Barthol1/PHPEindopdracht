<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;
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

Route::resource('/', DashboardController::class)->middleware(['auth'])->name('index', 'dashboard');
Route::controller(DashboardController::class)->group(function() {
    Route::get('/editpackage/{id}', 'editPackage')->name('editPackage');
    Route::put('/updatePackage/{id}', 'updatePackage')->name('updatePackage');
});

Route::group(['middleware' => ['role_or_permission:superadmin|administratief medewerker|pakket inpakker|lezen|schrijven']], function() {
    Route::resource('admindashboard', AdminDashboardController::class)->middleware(['auth']);
    Route::controller(AdminDashboardController::class)->group(function() {
        Route::get('/getpdf/{var1}', 'getPDF')->name('getpdf');
        Route::get('/allpdf', 'getAllPDF')->name('getallpdf');
        Route::put('/', 'updateWebshopClient')->name('updateWebshopClient');
        Route::put('/admindashboard', 'pickupPackage')->name('pickupPackage');
    });
});

require __DIR__.'/auth.php';
