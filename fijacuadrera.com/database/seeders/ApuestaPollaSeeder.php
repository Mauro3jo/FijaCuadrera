<?php

namespace Database\Seeders;

use App\Models\ApuestaPolla;
use Illuminate\Database\Seeder;

class ApuestaPollaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ApuestaPolla::factory()
            ->count(5)
            ->create();
    }
}
