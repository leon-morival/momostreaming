<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('movies');
})->middleware('auth');

Route::get('/movies/{imdbId}', function ($imdbId) {
    return view('movie_details', ['imdbId' => $imdbId]);
})->middleware('auth');

Route::get('/play/{imdbId}', function ($imdbId) {
    return view('play_movie', ['imdbId' => $imdbId]);
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/users', UserController::class);
});

require __DIR__.'/auth.php';
