<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\TagsController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\User\ThreadController;
use App\Http\Controllers\Api\User\CommentController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\User\BikeShopController;
use App\Http\Controllers\Api\User\BikeHotSpotController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'store']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('', [HomeController::class, 'index']);
    Route::prefix('users')->group(function () {


        Route::prefix('threads')->group(function () {
            Route::get('/{thread}/comments', [CommentController::class, 'index']);
            Route::post('/{thread}/comments', [CommentController::class, 'store']);
            Route::put('/{thread}/comments/{comment}', [CommentController::class, 'update']);
            Route::delete('/{thread}/comments/{comment}', [CommentController::class, 'destroy']);
        });
        Route::resource('tags', TagsController::class);
        Route::resource('threads', ThreadController::class)->except(['edit', 'create']);
        Route::resource('bike/shops', BikeShopController::class)->except(['edit', 'create']);
        Route::resource('bike/hotspot', BikeHotSpotController::class)->except(['edit', 'create']);
    });
    Route::delete('/logout', [LoginController::class, 'logout']);
});
