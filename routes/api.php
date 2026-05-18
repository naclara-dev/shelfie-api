<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\TitleController;
use App\Http\Controllers\UserController;
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
|---------------------------------
| Public - Read Only
|---------------------------------
*/
// Titles
Route::get('/titles', [TitleController::class, 'index']);
Route::get('/titles/{title}', [TitleController::class, 'show']);
Route::get('/genres/{genre}/titles', [GenreController::class, 'titles']);
Route::get('/titles/{title}/genres', [TitleController::class, 'genres']);

// Genres
Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/{genre}', [GenreController::class, 'show']);

// Ratings
Route::get('/ratings', [RatingController::class, 'index']);
Route::get('/ratings/{rating}', [RatingController::class, 'show']);

// Users
Route::get('/users/{user}/ratings', [UserController::class, 'ratings']);

// Authentication
Route::post('/login', [AuthController::class, 'login']);
Route::post('/users', [UserController::class, 'store']);

/*
|---------------------------------
| Protected - Common User Actions
|---------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Titles
    Route::post('/titles', [TitleController::class, 'store']);
    Route::put('/titles/{title}', [TitleController::class, 'update']);
    Route::patch('/titles/{title}', [TitleController::class, 'update']);
    Route::delete('/titles/{title}', [TitleController::class, 'destroy']);
    Route::get('/titles/{title}/ratings', [TitleController::class, 'ratings']);

    // Genres
    Route::post('/genres', [GenreController::class, 'store']);
    Route::put('/genres/{genre}', [GenreController::class, 'update']);
    Route::patch('/genres/{genre}', [GenreController::class, 'update']);
    Route::delete('/genres/{genre}', [GenreController::class, 'destroy']);

    // Ratings
    Route::post('/ratings', [RatingController::class, 'store']);
    Route::put('/ratings/{rating}', [RatingController::class, 'update']);
    Route::patch('/ratings/{rating}', [RatingController::class, 'update']);
    Route::delete('/ratings/{rating}', [RatingController::class, 'destroy']);

    // Users    
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::patch('/users/{user}', [UserController::class, 'update']);
});

/*
|---------------------------------
| Protected - Administration Actions
|---------------------------------
*/
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // Users
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
});
