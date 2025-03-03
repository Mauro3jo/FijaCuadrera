<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Carrera;

use App\Models\Hipico;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarreraTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_carreras_list(): void
    {
        $carreras = Carrera::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.carreras.index'));

        $response->assertOk()->assertSee($carreras[0]->nombre);
    }

    /**
     * @test
     */
    public function it_stores_the_carrera(): void
    {
        $data = Carrera::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.carreras.store'), $data);

        unset($data['estado']);

        $this->assertDatabaseHas('carreras', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_carrera(): void
    {
        $carrera = Carrera::factory()->create();

        $hipico = Hipico::factory()->create();

        $data = [
            'nombre' => $this->faker->word(255),
            'fecha' => $this->faker->dateTime(),
            'estado' => $this->faker->boolean(),
            'hipico_id' => $hipico->id,
        ];

        $response = $this->putJson(
            route('api.carreras.update', $carrera),
            $data
        );

        unset($data['estado']);

        $data['id'] = $carrera->id;

        $this->assertDatabaseHas('carreras', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_carrera(): void
    {
        $carrera = Carrera::factory()->create();

        $response = $this->deleteJson(route('api.carreras.destroy', $carrera));

        $this->assertModelMissing($carrera);

        $response->assertNoContent();
    }
}
