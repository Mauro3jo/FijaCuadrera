<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Caballo;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CaballoTest extends TestCase
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
    public function it_gets_caballos_list(): void
    {
        $caballos = Caballo::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.caballos.index'));

        $response->assertOk()->assertSee($caballos[0]->nombre);
    }

    /**
     * @test
     */
    public function it_stores_the_caballo(): void
    {
        $data = Caballo::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.caballos.store'), $data);

        $this->assertDatabaseHas('caballos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_caballo(): void
    {
        $caballo = Caballo::factory()->create();

        $data = [
            'nombre' => $this->faker->word(255),
            'edad' => $this->faker->randomNumber(2),
            'Raza' => $this->faker->word(255),
        ];

        $response = $this->putJson(
            route('api.caballos.update', $caballo),
            $data
        );

        $data['id'] = $caballo->id;

        $this->assertDatabaseHas('caballos', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_caballo(): void
    {
        $caballo = Caballo::factory()->create();

        $response = $this->deleteJson(route('api.caballos.destroy', $caballo));

        $this->assertModelMissing($caballo);

        $response->assertNoContent();
    }
}
