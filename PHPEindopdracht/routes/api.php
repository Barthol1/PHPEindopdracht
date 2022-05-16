<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PackageSignUpController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::apiResource('/packages', PackageSignUpController::class)->only('index');
    Route::controller(PackageSignUpController::class)->prefix('packages')->group(function() {
        Route::get('/get/{id}', 'get')->name('getPackage');
        Route::post('/store', 'store')->name('storePackage');
        Route::put('/{id}', 'update')->name('updatePackage');
        Route::delete('/{id}', 'destroy')->name('destroyPackage');
    });
});
