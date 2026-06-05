<?php

namespace Tests\Feature;

use App\Models\FavoriteItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FavoriteItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_rankings(): void
    {
        FavoriteItem::factory()->count(12)->create();

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Dynamic Ranking');
        $response->assertSee('Favorites Dashboard');
    }

    public function test_user_can_create_a_favorite_item(): void
    {
        Storage::fake('public');

        $response = $this->post(route('favorites.store'), [
            'name' => 'Mango Graham Shake',
            'category' => 'Drink',
            'description' => 'Cold, sweet, and perfect after a heavy meal.',
            'rating' => 4.9,
            'price' => 150,
            'calories' => 340,
            'favorite_level' => 10,
            'reaction' => 'yum',
            'mood_tags' => ['Sweet', 'Cold'],
            'image' => UploadedFile::fake()->image('mango.jpg', 800, 600),
        ]);

        $favorite = FavoriteItem::first();

        $response->assertRedirect(route('favorites.show', $favorite));
        $this->assertDatabaseHas('favorite_items', [
            'name' => 'Mango Graham Shake',
            'category' => 'Drink',
        ]);
        Storage::disk('public')->assertExists($favorite->image_url);
        $this->get($favorite->imageSource())->assertOk();
    }

    public function test_description_and_calories_are_optional_when_creating_a_favorite_item(): void
    {
        $response = $this->post(route('favorites.store'), [
            'name' => 'Plain Fries',
            'category' => 'Food',
            'rating' => 4.2,
            'price' => '49.50',
            'favorite_level' => 7,
            'reaction' => 'solid',
            'mood_tags' => ['Comfort Food'],
        ]);

        $favorite = FavoriteItem::first();

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('favorites.show', $favorite));
        $this->assertDatabaseHas('favorite_items', [
            'name' => 'Plain Fries',
            'description' => null,
            'calories' => null,
        ]);
    }

    public function test_food_battle_records_vote(): void
    {
        [$winner, $loser] = FavoriteItem::factory()
            ->count(2)
            ->create([
                'battle_wins' => 0,
                'battle_losses' => 0,
            ]);

        $this->post(route('favorites.battle.vote'), [
            'winner_id' => $winner->id,
            'loser_id' => $loser->id,
        ])->assertRedirect(route('favorites.battle'));

        $this->assertSame(1, $winner->fresh()->battle_wins);
        $this->assertSame(1, $loser->fresh()->battle_losses);
    }

    public function test_food_battle_ends_after_selected_rounds(): void
    {
        [$winner, $loser] = FavoriteItem::factory()
            ->count(2)
            ->create([
                'battle_wins' => 0,
                'battle_losses' => 0,
            ]);

        $this->get(route('favorites.battle', ['rounds' => 3]))->assertOk();

        for ($round = 1; $round <= 3; $round++) {
            $this->post(route('favorites.battle.vote'), [
                'winner_id' => $winner->id,
                'loser_id' => $loser->id,
            ])->assertRedirect(route('favorites.battle'));
        }

        $this->assertTrue(session('food_battle.finished'));

        $this->get(route('favorites.battle'))
            ->assertOk()
            ->assertSee("{$winner->name} wins the Food Battle");
    }
}
