<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/getMovies', [MovieController::class, 'getMovies']);

Route::get('/', [MovieController::class, 'home'])->name('home');
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');
