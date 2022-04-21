<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PackageSignUpController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
// Route::post('/auth/login', [AuthenticatedSessionController::class, 'login']);

// Route::post('/tokens/create', function (Request $request) {
//     $token = $request->user()->createToken($request->token_name);

//     return ['token' => $token->plainTextToken];
// });

// Route::group(['middleware' => ['auth:sanctum']], function() {
//     Route::apiResource('/packages', PackageSignUpController::class);
//     Route::get('/packages/get/{id}', [PackageSignUpController::class, 'get']);
//     Route::post('/packages/store', [PackageSignUpController::class, 'store']);
//     Route::put('/packages/{id}', [PackageSignUpController::class, 'update']);
//     Route::delete('/packages/{id}', [PackageSignUpController::class, 'destroy']);
//     // return $request->user();
// });


Route::middleware('auth:api')->group(function () {
    Route::apiResource('/', PackageSignUpController::class)->only('index');
    Route::controller(PackageSignUpController::class)->prefix('packages')->group(function() {
        Route::get('/get/{id}', 'get')->name('packages.get');
        Route::post('/store', 'store')->name('packages.store');
        Route::put('/{id}', 'update')->name('packages.update');
        Route::delete('/{id}', 'destroy')->name('packages.destroy');
    });
});

Route::apiResource('admindashboard/package', PackageSignUpController::class);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::delete('admindashboard/package/{id}', [PackageSignUpController::class, 'update']);
    Route::put('admindashboard/package/{id}', [PackageSignUpController::class, 'destroy']);
});
// Route::apiResource('package', PackageSignUpController::class)->middleware('auth:api');
// Route::delete('package/{id}', [PackageSignUpController::class, 'destroy']);

// Route::middleware(['auth:api', 'superadmin'])->group(function() {
//     // Route::get('/', PackageSignUpController::class);
// });
