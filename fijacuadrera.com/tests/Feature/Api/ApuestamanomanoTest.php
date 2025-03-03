<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Apuestamanomano;

use App\Models\Carrera;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApuestamanomanoTest extends TestCase
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
    public function it_gets_apuestamanomanos_list(): void
    {
        $apuestamanomanos = Apuestamanomano::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.apuestamanomanos.index'));

        $response->assertOk()->assertSee($apuestamanomanos[0]->Caballo1);
    }

    /**
     * @test
     */
    public function it_stores_the_apuestamanomano(): void
    {
        $data = Apuestamanomano::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.apuestamanomanos.store'), $data);

        unset($data['Monto1']);
        unset($data['Monto2']);

        $this->assertDatabaseHas('apuestamanomanos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_apuestamanomano(): void
    {
        $apuestamanomano = Apuestamanomano::factory()->create();

        $carrera = Carrera::factory()->create();

        $data = [
            'Ganancia' => $this->faker->randomNumber(2),
            'Caballo1' => $this->faker->text(255),
            'Caballo2' => $this->faker->text(255),
            'Monto1' => $this->faker->randomNumber(2),
            'Monto2' => $this->faker->randomNumber(2),
            'Tipo' => $this->faker->text(255),
            'Estado' => $this->faker->boolean(),
            'carrera_id' => $carrera->id,
        ];

        $response = $this->putJson(
            route('api.apuestamanomanos.update', $apuestamanomano),
            $data
        );

        unset($data['Monto1']);
        unset($data['Monto2']);

        $data['id'] = $apuestamanomano->id;

        $this->assertDatabaseHas('apuestamanomanos', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_apuestamanomano(): void
    {
        $apuestamanomano = Apuestamanomano::factory()->create();

        $response = $this->deleteJson(
            route('api.apuestamanomanos.destroy', $apuestamanomano)
        );

        $this->assertModelMissing($apuestamanomano);

        $response->assertNoContent();
    }
}
