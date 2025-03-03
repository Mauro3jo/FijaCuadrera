<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ApuestaPolla;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApuestaPollaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApuestaPolla::class;

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
            'Monto1' => $this->faker->randomNumber(2),
            'Caballo2' => $this->faker->text(255),
            'Monto2' => $this->faker->randomNumber(2),
            'Caballo3' => $this->faker->text(255),
            'Monto3' => $this->faker->randomNumber(2),
            'Caballo4' => $this->faker->text(255),
            'Monto4' => $this->faker->randomNumber(2),
            'Caballo5' => $this->faker->text(255),
            'Monto5' => $this->faker->randomNumber(2),
            'Estado' => $this->faker->boolean(),
            'carrera_id' => \App\Models\Carrera::factory(),
        ];
    }
}
