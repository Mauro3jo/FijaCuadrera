<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ApuestamanomanoUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApuestamanomanoUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApuestamanomanoUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'resultadoapuesta' => $this->faker->text(255),
            'apuestamanomano_id' => \App\Models\Apuestamanomano::factory(),
            'user_id' => \App\Models\User::factory(),
            'caballo_id' => \App\Models\Caballo::factory(),
        ];
    }
}
