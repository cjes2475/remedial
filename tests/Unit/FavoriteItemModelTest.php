<?php

namespace Tests\Unit;

use App\Models\FavoriteItem;
use PHPUnit\Framework\TestCase;

class FavoriteItemModelTest extends TestCase
{
    public function test_battle_win_rate_is_calculated_from_wins_and_losses(): void
    {
        $favorite = new FavoriteItem([
            'battle_wins' => 3,
            'battle_losses' => 1,
        ]);

        $this->assertSame(75.0, $favorite->battleWinRate());
    }
}
