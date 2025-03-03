<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);

        $this->call(ApuestamanomanoSeeder::class);
        $this->call(ApuestamanomanoUserSeeder::class);
        $this->call(ApuestaPollaSeeder::class);
        $this->call(ApuestaPollaUserSeeder::class);
        $this->call(CaballoSeeder::class);
        $this->call(CarreraSeeder::class);
        $this->call(ContactoSeeder::class);
        $this->call(FormapagoSeeder::class);
        $this->call(HipicoSeeder::class);
        $this->call(UserSeeder::class);
    }
}
