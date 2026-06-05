<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE favorite_items MODIFY description TEXT NULL, MODIFY calories INT UNSIGNED NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE favorite_items ALTER COLUMN description DROP NOT NULL');
            DB::statement('ALTER TABLE favorite_items ALTER COLUMN calories DROP NOT NULL');
        }
    }

    public function down(): void
    {
        $driver = DB::connection()->getDriverName();

        DB::table('favorite_items')->whereNull('description')->update(['description' => '']);
        DB::table('favorite_items')->whereNull('calories')->update(['calories' => 0]);

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE favorite_items MODIFY description TEXT NOT NULL, MODIFY calories INT UNSIGNED NOT NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE favorite_items ALTER COLUMN description SET NOT NULL');
            DB::statement('ALTER TABLE favorite_items ALTER COLUMN calories SET NOT NULL');
        }
    }
};
