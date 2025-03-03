<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApuestaPollaUser;

class ApuestaPollaUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ApuestaPollaUser::factory()
            ->count(5)
            ->create();
    }
}
