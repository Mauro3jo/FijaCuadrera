<?php

namespace Database\Factories;

use App\Models\Formapago;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormapagoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Formapago::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cbu' => $this->faker->randomNumber(2),
            'alias' => $this->faker->word(255),
        ];
    }
}
