<?php

use App\Models\FavoriteItem;
use Illuminate\Support\Facades\Route;

Route::get('/favorites', function () {
    return FavoriteItem::orderByDesc('rating')
        ->orderByDesc('favorite_level')
        ->get();
});

Route::get('/favorites/top-10', function () {
    return FavoriteItem::orderByDesc('rating')
        ->orderByDesc('favorite_level')
        ->limit(10)
        ->get();
});
