<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApuestamanomanoUser;

class ApuestamanomanoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ApuestamanomanoUser::factory()
            ->count(5)
            ->create();
    }
}
