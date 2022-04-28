<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TracingController;
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

Route::resource('/dashboard', DashboardController::class)->middleware(['auth'])->name('index', 'dashboard');
Route::controller(DashboardController::class)->group(function() {
    Route::get('/editpackage/{id}', 'editPackage')->name('editPackage');
    Route::put('/updatePackage/{id}', 'updatePackage')->name('updatePackage');
    Route::get('/addreview/{id}', 'addReview')->name('addreview');
    Route::post('/import', 'importCSV')->name('importcsv');
    Route::get('/dashboardSearch', 'search')->name('dashboardSearch');
});

Route::group(['middleware' => ['role_or_permission:superadmin|administratief medewerker|pakket inpakker|lezen|schrijven']], function() {
    Route::resource('/admindashboard', AdminDashboardController::class)->middleware(['auth']);
    Route::controller(AdminDashboardController::class)->group(function() {
        Route::get('/getpdf/{var1}', 'getPDF')->name('getpdf');
        Route::get('/allpdf', 'getAllPDF')->name('getallpdf');
        Route::get('/adminSearch', 'search')->name('adminSearch');
        Route::put('/updateWebshopClient', 'updateWebshopClient')->name('updateWebshopClient');
        Route::put('/pickupPackage', 'pickupPackage')->name('pickupPackage');
    });
});

Route::resource('/', TracingController::class);
Route::get('/getpackage', [TracingController::class, 'getPackage'])->name('getpackage');

require __DIR__.'/auth.php';
