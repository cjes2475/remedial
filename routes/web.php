<?php

use App\Http\Controllers\FavoriteItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FavoriteItemController::class, 'dashboard'])->name('dashboard');
Route::get('/mood', [FavoriteItemController::class, 'mood'])->name('favorites.mood');
Route::get('/surprise-me', [FavoriteItemController::class, 'surprise'])->name('favorites.surprise');
Route::get('/food-battle', [FavoriteItemController::class, 'battle'])->name('favorites.battle');
Route::post('/food-battle/vote', [FavoriteItemController::class, 'voteBattle'])->name('favorites.battle.vote');
Route::get('/favorite-images/{path}', [FavoriteItemController::class, 'image'])
    ->where('path', '.*')
    ->name('favorites.image');

Route::resource('favorites', FavoriteItemController::class);
