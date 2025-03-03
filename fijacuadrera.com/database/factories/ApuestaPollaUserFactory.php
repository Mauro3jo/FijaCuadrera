<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ApuestaPollaUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApuestaPollaUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApuestaPollaUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Resultadoapuesta' => $this->faker->text(255),
            'apuesta_polla_id' => \App\Models\ApuestaPolla::factory(),
            'user_id' => \App\Models\User::factory(),
            'caballo_id' => \App\Models\Caballo::factory(),
        ];
    }
}
