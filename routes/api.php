<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\DailyMovieController;
use App\Http\Controllers\Api\TrendingMovieController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminDataController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/ratings', [RatingController::class, 'index']);
//Route::get('/users', [UserController::class, 'index']);
Route::get('/admin/get', [AdminDataController::class, 'index']);
Route::get('/get-daily', [DailyMovieController::class, 'index']);

Route::put('/movies/{movie}', [MovieController::class, 'update']);
Route::put('/ratings/{rating}', [RatingController::class, 'update']);
Route::post('/daily-movies', [DailyMovieController::class, 'store']);
Route::post('/trending-movies', [TrendingMovieController::class, 'store']);
Route::post('/admin/login', [UserController::class, 'adminLogin']);
Route::post('/admin/update', [AdminDataController::class, 'update']);