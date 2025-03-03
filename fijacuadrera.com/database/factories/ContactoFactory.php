<?php

namespace Database\Factories;

use App\Models\Contacto;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contacto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'celular' => $this->faker->randomNumber(2),
            'HoraDisponible' => $this->faker->word(255),
        ];
    }
}
