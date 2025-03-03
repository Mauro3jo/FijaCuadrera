<?php

namespace Database\Factories;

use App\Models\Caballo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CaballoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Caballo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(255),
            'edad' => $this->faker->randomNumber(2),
            'Raza' => $this->faker->word(255),
        ];
    }
}
