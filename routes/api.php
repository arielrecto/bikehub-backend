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
use App\Http\Controllers\BikeRouteController;
use App\Http\Controllers\UpvoteController;

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
    $user = $request->user();
    $user->load('roles');
    return $user;
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('', [HomeController::class, 'index']);

    Route::prefix('users')->group(function () {
        Route::prefix('threads')->group(function () {
            Route::get('/random', [ThreadController::class, 'randomThreads']);
            
            Route::get('/{thread}/comments', [CommentController::class, 'index']);
            Route::get(
                '/{thread}/comments/{comment}/replies',
                [CommentController::class, 'replies']
            );

            Route::post('/{thread}/comments', [CommentController::class, 'store']);
            Route::patch(
                '/{thread}/comments/{comment}',
                [CommentController::class, 'update']
            );

            Route::delete(
                '/{thread}/comments/{comment}',
                [CommentController::class, 'destroy']
            );
        });

        Route::apiResource('tags', TagsController::class);
        Route::apiResource('upvotes', UpvoteController::class);
        Route::resource('threads', ThreadController::class)->except(['edit', 'create']);
        Route::apiResource('bike-routes', BikeRouteController::class);
        Route::resource('bike/shops', BikeShopController::class)->except(['edit', 'create']);
        Route::resource('bike/hotspot', BikeHotSpotController::class)->except(['edit', 'create']);
    });

    Route::delete('/logout', [LoginController::class, 'logout']);
});
