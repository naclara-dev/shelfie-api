<?php

use App\Http\Controllers\AuthController;
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

/*
| GENERAL
*/
Route::apiResource('items', ItemController::class);
Route::apiResource('genres', GenreController::class);
Route::apiResource('users', UserController::class);

/*
| PROTECTED - USER ACTIONS
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('ratings', RatingController::class);    
});

Route::get('items/{item}/genres', [ItemController::class, 'genres']);
Route::post('/login', [AuthController::class, 'login']);
