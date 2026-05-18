<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\TitleController;
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
Route::apiResource('titles', TitleController::class);
Route::apiResource('genres', GenreController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('ratings', RatingController::class)->only(['index', 'show']);

/*
| PROTECTED - USER ACTIONS
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);  
    Route::get('titles/{title}/ratings', [TitleController::class, 'ratings']);  
    Route::post('/ratings', [RatingController::class, 'store']);
    Route::put('/ratings/{rating}', [RatingController::class, 'update']);
    Route::patch('/ratings/{rating}', [RatingController::class, 'update']);
    Route::delete('/ratings/{rating}', [RatingController::class, 'destroy']);
});

/*
| CUSTOM
*/
Route::get('genres/{genre}/titles', [GenreController::class, 'titles']);
Route::get('titles/{title}/genres', [TitleController::class, 'genres']);
Route::post('/login', [AuthController::class, 'login']);
