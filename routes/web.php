<?php

use App\Http\Controllers\PavSolController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PavSolController::class, 'showLogin'])->name('login');
Route::post('/login', [PavSolController::class, 'login'])->name('login.submit');
Route::get('/register', [PavSolController::class, 'showRegister'])->name('register');
Route::post('/register', [PavSolController::class, 'register'])->name('register.submit');
Route::get('/verify', [PavSolController::class, 'showVerify'])->name('verify');
Route::post('/verify', [PavSolController::class, 'verify'])->name('verify.submit');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PavSolController::class, 'dashboard'])->name('dashboard');
    Route::get('/favoritos', [PavSolController::class, 'listFavorites'])->name('favorites');
    Route::post('/favoritos', [PavSolController::class, 'saveFavorite'])->name('favorites.save');
    Route::get('/favoritos/delete/{id}', [PavSolController::class, 'deleteFavorite'])->name('favorites.delete');
    Route::get('/quem-somos', [PavSolController::class, 'about'])->name('about');
    Route::get('/logout', [PavSolController::class, 'logout'])->name('logout');
});
