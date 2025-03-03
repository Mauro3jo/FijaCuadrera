<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Apuestamanomano;

class ApuestamanomanoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Apuestamanomano::factory()
            ->count(5)
            ->create();
    }
}
