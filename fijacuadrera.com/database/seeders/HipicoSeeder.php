<?php

namespace Database\Seeders;

use App\Models\Hipico;
use Illuminate\Database\Seeder;

class HipicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hipico::factory()
            ->count(5)
            ->create();
    }
}
