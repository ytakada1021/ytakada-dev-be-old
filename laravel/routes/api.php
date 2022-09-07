<?php

use App\Http\Controllers\CreateOrUpdatePostController;
use App\Http\Controllers\DeletePostController;
use App\Http\Controllers\GetPostController;
use App\Http\Controllers\GetPostListController;
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

Route::get('/health', function () {
    return "health";
});

Route::prefix('/posts')->group(function () {
    Route::get('/', GetPostListController::class);
    Route::post('/', CreateOrUpdatePostController::class)->middleware('apikey');
    Route::get('/{postId}', GetPostController::class);
    Route::delete('/{postId}', DeletePostController::class)->middleware('apikey');
});
