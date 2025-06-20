<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\authorize;
use App\Http\Middleware\isAdmin;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware([authorize::class])->group(function () {
    Route::get('/movies', [MovieController::class, 'index']);
    Route::get('/movies/hero', [MovieController::class, 'hero']);
    Route::get('/movies/{id}', [MovieController::class, 'movieById']);

    Route::get('/genres/top', [GenreController::class, 'topGenres']);
    Route::get('/genres/q/{genre}', [GenreController::class, 'query']);
    Route::get('/genres/main', [GenreController::class, 'mainGenres']);
    Route::get('/m/{title}', [MovieController::class, 'get']);
    Route::get('/genres/all', [GenreController::class, 'all']);
});

Route::get('/authenticate', [AuthController::class, 'authenticate']);
Route::post('/signout', [UserController::class, 'signout']);

Route::middleware([isAdmin::class])->group(function () {
    Route::post('/movies', [MovieController::class, 'insert']);
    Route::put('/movies', [MovieController::class, 'update']);
    Route::delete('/movies/{id}', [MovieController::class, 'delete']);
});

Route::post('/signin', [UserController::class, 'signin']);
Route::post('/register', [UserController::class, 'register']);
