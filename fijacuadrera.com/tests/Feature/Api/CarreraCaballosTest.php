<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Carrera;
use App\Models\Caballo;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarreraCaballosTest extends TestCase
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
    public function it_gets_carrera_caballos(): void
    {
        $carrera = Carrera::factory()->create();
        $caballo = Caballo::factory()->create();

        $carrera->caballos()->attach($caballo);

        $response = $this->getJson(
            route('api.carreras.caballos.index', $carrera)
        );

        $response->assertOk()->assertSee($caballo->nombre);
    }

    /**
     * @test
     */
    public function it_can_attach_caballos_to_carrera(): void
    {
        $carrera = Carrera::factory()->create();
        $caballo = Caballo::factory()->create();

        $response = $this->postJson(
            route('api.carreras.caballos.store', [$carrera, $caballo])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $carrera
                ->caballos()
                ->where('caballos.id', $caballo->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_caballos_from_carrera(): void
    {
        $carrera = Carrera::factory()->create();
        $caballo = Caballo::factory()->create();

        $response = $this->deleteJson(
            route('api.carreras.caballos.store', [$carrera, $caballo])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $carrera
                ->caballos()
                ->where('caballos.id', $caballo->id)
                ->exists()
        );
    }
}
