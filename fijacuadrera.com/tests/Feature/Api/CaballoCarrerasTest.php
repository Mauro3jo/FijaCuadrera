<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Caballo;
use App\Models\Carrera;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CaballoCarrerasTest extends TestCase
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
    public function it_gets_caballo_carreras(): void
    {
        $caballo = Caballo::factory()->create();
        $carrera = Carrera::factory()->create();

        $caballo->carreras()->attach($carrera);

        $response = $this->getJson(
            route('api.caballos.carreras.index', $caballo)
        );

        $response->assertOk()->assertSee($carrera->nombre);
    }

    /**
     * @test
     */
    public function it_can_attach_carreras_to_caballo(): void
    {
        $caballo = Caballo::factory()->create();
        $carrera = Carrera::factory()->create();

        $response = $this->postJson(
            route('api.caballos.carreras.store', [$caballo, $carrera])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $caballo
                ->carreras()
                ->where('carreras.id', $carrera->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_carreras_from_caballo(): void
    {
        $caballo = Caballo::factory()->create();
        $carrera = Carrera::factory()->create();

        $response = $this->deleteJson(
            route('api.caballos.carreras.store', [$caballo, $carrera])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $caballo
                ->carreras()
                ->where('carreras.id', $carrera->id)
                ->exists()
        );
    }
}
