<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'rating',
        'calories',
        'price',
        'favorite_level',
        'image_url',
        'mood_tags',
        'reaction',
        'battle_wins',
        'battle_losses',
        'last_battled_at',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'price' => 'decimal:2',
        'calories' => 'integer',
        'favorite_level' => 'integer',
        'mood_tags' => 'array',
        'battle_wins' => 'integer',
        'battle_losses' => 'integer',
        'last_battled_at' => 'datetime',
    ];

    public const CATEGORIES = [
        'Food',
        'Drink',
        'Dessert',
        'Snack',
    ];

    public const MOODS = [
        'Sweet',
        'Spicy',
        'Cold',
        'Heavy Meal',
        'Comfort Food',
    ];

    public function battleWinRate(): float
    {
        $total = $this->battle_wins + $this->battle_losses;

        return $total === 0 ? 0 : round(($this->battle_wins / $total) * 100, 1);
    }

    public function imageSource(): ?string
    {
        if (! $this->image_url) {
            return null;
        }

        if (str_starts_with($this->image_url, 'http')) {
            return $this->image_url;
        }

        return route('favorites.image', ['path' => $this->image_url]);
    }
}
