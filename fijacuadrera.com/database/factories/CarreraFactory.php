<?php

namespace Database\Factories;

use App\Models\Carrera;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarreraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Carrera::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(255),
            'fecha' => $this->faker->dateTime(),
            'estado' => $this->faker->boolean(),
            'hipico_id' => \App\Models\Hipico::factory(),
        ];
    }
}
