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
Route::get('/getpdf/{var1}', [DashboardController::class, 'getPDF'])->name('getpdf');

Route::resource('admindashboard', AdminDashboardController::class)->middleware(['auth']);

Route::group(['middleware' => ['role:superadmin']], function() {

});
Route::group(['middleware' => ['role:administratief medewerker']], function() {

});
Route::group(['middleware' => ['role:pakket inpakker']], function() {

});
Route::group(['middleware' => ['role_or_permission:superadmin|schrijven']], function() {

});
Route::group(['middleware' => ['role_or_permission:superadmin|lezen']], function() {

});

require __DIR__.'/auth.php';
