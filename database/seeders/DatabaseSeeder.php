<?php

namespace Database\Seeders;

use App\Models\FavoriteItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Remedial Student',
                'password' => Hash::make('password'),
            ]
        );

        $featuredItems = [
            ['name' => 'Matcha Latte', 'category' => 'Drink', 'rating' => 4.9, 'price' => 165, 'calories' => 220, 'favorite_level' => 10, 'mood_tags' => ['Sweet', 'Cold', 'Comfort Food'], 'reaction' => 'wow', 'image_url' => 'https://images.unsplash.com/photo-1515823064-d6e0c04616a7?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'Crispy Sisig', 'category' => 'Food', 'rating' => 4.8, 'price' => 190, 'calories' => 620, 'favorite_level' => 10, 'mood_tags' => ['Spicy', 'Heavy Meal', 'Comfort Food'], 'reaction' => 'fire', 'image_url' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'Tonkotsu Ramen', 'category' => 'Food', 'rating' => 4.7, 'price' => 280, 'calories' => 760, 'favorite_level' => 9, 'mood_tags' => ['Heavy Meal', 'Comfort Food'], 'reaction' => 'warm', 'image_url' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'Iced Coffee', 'category' => 'Drink', 'rating' => 4.6, 'price' => 120, 'calories' => 110, 'favorite_level' => 8, 'mood_tags' => ['Cold', 'Comfort Food'], 'reaction' => 'boost', 'image_url' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'Mango Graham Shake', 'category' => 'Drink', 'rating' => 4.9, 'price' => 150, 'calories' => 340, 'favorite_level' => 10, 'mood_tags' => ['Sweet', 'Cold', 'Comfort Food'], 'reaction' => 'yum', 'image_url' => 'https://images.unsplash.com/photo-1622597467836-f3285f2131b8?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'Chicken Shawarma Rice', 'category' => 'Food', 'rating' => 4.5, 'price' => 170, 'calories' => 680, 'favorite_level' => 8, 'mood_tags' => ['Heavy Meal', 'Comfort Food'], 'reaction' => 'solid', 'image_url' => 'https://images.unsplash.com/photo-1529006557810-274b9b2fc783?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'Strawberry Cheesecake', 'category' => 'Dessert', 'rating' => 4.7, 'price' => 180, 'calories' => 430, 'favorite_level' => 9, 'mood_tags' => ['Sweet', 'Cold'], 'reaction' => 'sweet', 'image_url' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'Spicy Korean Wings', 'category' => 'Food', 'rating' => 4.6, 'price' => 240, 'calories' => 710, 'favorite_level' => 9, 'mood_tags' => ['Spicy', 'Heavy Meal'], 'reaction' => 'kick', 'image_url' => 'https://images.unsplash.com/photo-1527477396000-e27163b481c2?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'Classic Milk Tea', 'category' => 'Drink', 'rating' => 4.4, 'price' => 135, 'calories' => 310, 'favorite_level' => 8, 'mood_tags' => ['Sweet', 'Cold'], 'reaction' => 'smooth', 'image_url' => 'https://images.unsplash.com/photo-1558857563-b371033873b8?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'Loaded Nachos', 'category' => 'Snack', 'rating' => 4.3, 'price' => 210, 'calories' => 540, 'favorite_level' => 7, 'mood_tags' => ['Spicy', 'Comfort Food'], 'reaction' => 'crunch', 'image_url' => 'https://images.unsplash.com/photo-1513456852971-30c0b8199d4d?auto=format&fit=crop&w=900&q=80'],
        ];

        foreach ($featuredItems as $item) {
            FavoriteItem::query()->updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }

        $missingCount = max(0, 30 - FavoriteItem::query()->count());

        if ($missingCount > 0) {
            FavoriteItem::factory()
                ->count($missingCount)
                ->create();
        }
    }
}
