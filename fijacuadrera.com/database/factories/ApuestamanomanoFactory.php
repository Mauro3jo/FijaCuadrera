<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Apuestamanomano;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApuestamanomanoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Apuestamanomano::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Ganancia' => $this->faker->randomNumber(2),
            'Caballo1' => $this->faker->text(255),
            'Caballo2' => $this->faker->text(255),
            'Monto1' => $this->faker->randomNumber(2),
            'Monto2' => $this->faker->randomNumber(2),
            'Tipo' => $this->faker->text(255),
            'Estado' => $this->faker->boolean(),
            'carrera_id' => \App\Models\Carrera::factory(),
        ];
    }
}
