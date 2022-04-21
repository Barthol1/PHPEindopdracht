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
    Route::controller(PackageSignUpController::class)->prefix('packages')->group(function() {
        Route::apiResource('/', PackageSignUpController::class)->only('index');
        Route::get('/get/{id}', 'get')->name('packages.get');
        Route::post('/store', 'store')->name('packages.store');
        Route::put('/{id}', 'update')->name('packages.update');
        Route::delete('/{id}', 'destroy')->name('packages.destroy');
    });
});
