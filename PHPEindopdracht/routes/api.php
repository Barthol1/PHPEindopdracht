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
