<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', App\Http\Controllers\Api\User\RegisterController::class)->name('register');
Route::post('/login', App\Http\Controllers\Api\User\LoginController::class)->name('login');
Route::middleware('auth:api')->get('/user', function(Request $request){
    return $request->user();
});
Route::post('/logout', App\Http\Controllers\Api\User\LogoutController::class)->name('logout');
Route::middleware('auth:api')->group(function () {
    Route::apiResource('/category-products', App\Http\Controllers\Api\MasterData\CategoryController::class);
    Route::apiResource('/products', App\Http\Controllers\Api\MasterData\ProductController::class);
});
