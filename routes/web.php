<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', [MovieController::class, 'home'])->name('home');
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

Route::get('/rolunk', function () {
    return view('pages.about');
})->name('about');

Route::get('/bejelentkezes', function () {
    return view('auth.login');
})->name('login');

Route::get('/regisztracio', function () {
    return view('auth.register');
})->name('register');
