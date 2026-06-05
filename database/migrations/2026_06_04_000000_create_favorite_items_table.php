<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorite_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->text('description')->nullable();
            $table->decimal('rating', 2, 1);
            $table->unsignedInteger('calories')->nullable();
            $table->decimal('price', 8, 2);
            $table->unsignedTinyInteger('favorite_level');
            $table->string('image_url')->nullable();
            $table->json('mood_tags')->nullable();
            $table->string('reaction', 16)->nullable();
            $table->unsignedInteger('battle_wins')->default(0);
            $table->unsignedInteger('battle_losses')->default(0);
            $table->timestamp('last_battled_at')->nullable();
            $table->timestamps();

            $table->index(['category', 'rating']);
            $table->index('favorite_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorite_items');
    }
};
