<?php

namespace Database\Seeders;

use App\Models\Caballo;
use Illuminate\Database\Seeder;

class CaballoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Caballo::factory()
            ->count(5)
            ->create();
    }
}
