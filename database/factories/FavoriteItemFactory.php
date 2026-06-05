<?php

namespace Database\Factories;

use App\Models\FavoriteItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FavoriteItem>
 */
class FavoriteItemFactory extends Factory
{
    protected $model = FavoriteItem::class;

    public function definition(): array
    {
        $category = fake()->randomElement(FavoriteItem::CATEGORIES);
        $moods = fake()->randomElements(FavoriteItem::MOODS, fake()->numberBetween(1, 3));

        $names = [
            'Food' => ['Garlic Butter Steak Bowl', 'Crispy Chicken Burger', 'Seafood Carbonara', 'Beef Pares', 'Kimchi Fried Rice', 'Cheesy Baked Sushi'],
            'Drink' => ['Brown Sugar Milk Tea', 'Cucumber Lemonade', 'Caramel Cold Brew', 'Watermelon Slush', 'Thai Iced Tea', 'Hot Chocolate'],
            'Dessert' => ['Ube Halo-Halo', 'Chocolate Lava Cake', 'Leche Flan Cup', 'Blueberry Waffle', 'Mango Sticky Rice', 'Cookies and Cream Sundae'],
            'Snack' => ['Takoyaki Bites', 'Cheese Fries', 'Potato Mojos', 'Corn Dog', 'Chicken Nuggets', 'Turon Rolls'],
        ];

        $images = [
            'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1550547660-d9450f859349?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1505253716362-afaea1d3d1af?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=900&q=80',
            'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=900&q=80',
        ];

        return [
            'name' => fake()->randomElement($names[$category]),
            'category' => $category,
            'description' => fake()->sentence(18),
            'rating' => fake()->randomFloat(1, 3.2, 5),
            'calories' => fake()->numberBetween(80, 950),
            'price' => fake()->randomFloat(2, 55, 450),
            'favorite_level' => fake()->numberBetween(1, 10),
            'image_url' => fake()->randomElement($images),
            'mood_tags' => array_values($moods),
            'reaction' => fake()->randomElement(['yum', 'wow', 'fire', 'fresh', 'cozy', 'cool']),
            'battle_wins' => fake()->numberBetween(0, 8),
            'battle_losses' => fake()->numberBetween(0, 6),
            'last_battled_at' => fake()->optional()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
