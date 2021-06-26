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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh'])->name('refresh');
    Route::get('me', [\App\Http\Controllers\AuthController::class, 'me'])->name('me');
});

Route::group([
    'prefix' => 'categories'
], function ($router) {
        Route::get('/', [\App\Http\Controllers\CategoryController::class, 'index']);
        Route::get('/products', [\App\Http\Controllers\CategoryController::class, 'products']);
});



Route::group([
    'prefix' => 'products'
], function ($router) {
        Route::get('/', [\App\Http\Controllers\ProductController::class, 'index']);
        Route::post('/create', [\App\Http\Controllers\ProductController::class, 'create']);
        Route::post('/modify', [\App\Http\Controllers\ProductController::class, 'modify']);
        Route::get('/destroy/{id}', [\App\Http\Controllers\ProductController::class, 'destroy']);
});



