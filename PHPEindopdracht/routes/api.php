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
// Route::post('/auth/register', [AuthenticatedSessionController::class, 'register']);

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


Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::controller(PackageSignUpController::class)->prefix('packages')->group(function() {
        Route::apiResource('/', PackageSignUpController::class)->only('index');
        Route::get('/get/{id}', 'get')->name('packages.get');
        Route::post('/store', 'store')->name('packages.store');
        Route::put('/{id}', 'update')->name('packages.update');
        Route::delete('/{id}', 'destroy')->name('packages.destroy');
    });
});

// Route::apiResource('package', PackageSignUpController::class)->middleware('auth:sanctum');

// Route::middleware('auth:api')->get('/user', function(Request $request) {
//     return app()->request()->user();
// });

// Route::middleware('auth:sanctum')->get('/user', function () {
//     Route::get('/package/get/{id}', [PackageSignUpController::class, 'get']);

//     // Route::get('/me', function(Request $request) {
//     //     return auth()->user();
//     // });
//     // Route::post('/package/store', [PackageSignUpController::class, 'store']);
//     // Route::put('/package/{id}', [PackageSignUpController::class, 'update']);
//     // Route::delete('/package/{id}', [PackageSignUpController::class, 'destroy']);
// });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     // return $request->user();
// });

Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});
// Route::apiResource('package', PackageSignUpController::class)->middleware('auth:api');
// Route::delete('package/{id}', [PackageSignUpController::class, 'destroy']);

// Route::middleware(['auth:api', 'superadmin'])->group(function() {
//     // Route::get('/', PackageSignUpController::class);
// });
