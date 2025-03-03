<?php

namespace Database\Factories;

use App\Models\Hipico;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class HipicoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hipico::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(255),
            'direccion' => $this->faker->word(255),
        ];
    }
}
