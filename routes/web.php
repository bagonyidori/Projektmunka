<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/register', [AuthController::class, 'registerUser'])->name('user.register');
Route::post('/login', [AuthController::class, 'loginUser'])->name('user.login');

Route::post('/logout', [AuthController::class, 'logoutUser'])->name('user.logout');

Route::get('/', [MovieController::class, 'home'])->name('home');
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');
Route::post("/movies/{id}/rating", [RatingController::class, 'store'])->name('rating.create');

Route::get('/rolunk', function () {
    return view('pages.about');
})->name('about');

Route::get('/profile', [App\Http\Controllers\MovieController::class, 'profile'])
    ->name('profile')
    ->middleware('auth');


//lehet majd egy külön controllerbe kell tenni
$user = auth()->user();
return view('profile.profile', [
    'user' => $user,
]);



// Route::get('/bejelentkezes', function () {
//     return view('auth.login');
// })->name('login');

// Route::get('/regisztracio', function () {
//     return view('auth.register');
// })->name('register');
