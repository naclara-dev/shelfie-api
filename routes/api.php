<?php

use App\Http\Controllers\GenreController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('items', ItemController::class);
Route::apiResource('genres', GenreController::class);
Route::apiResource('ratings', RatingController::class);
Route::apiResource('users', UserController::class);

Route::get('items/{item}/genres', [ItemController::class, 'genres']);
