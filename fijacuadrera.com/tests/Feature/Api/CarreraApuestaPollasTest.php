<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Carrera;
use App\Models\ApuestaPolla;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarreraApuestaPollasTest extends TestCase
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
    public function it_gets_carrera_apuesta_pollas(): void
    {
        $carrera = Carrera::factory()->create();
        $apuestaPollas = ApuestaPolla::factory()
            ->count(2)
            ->create([
                'carrera_id' => $carrera->id,
            ]);

        $response = $this->getJson(
            route('api.carreras.apuesta-pollas.index', $carrera)
        );

        $response->assertOk()->assertSee($apuestaPollas[0]->Caballo1);
    }

    /**
     * @test
     */
    public function it_stores_the_carrera_apuesta_pollas(): void
    {
        $carrera = Carrera::factory()->create();
        $data = ApuestaPolla::factory()
            ->make([
                'carrera_id' => $carrera->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.carreras.apuesta-pollas.store', $carrera),
            $data
        );

        $this->assertDatabaseHas('apuesta_pollas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $apuestaPolla = ApuestaPolla::latest('id')->first();

        $this->assertEquals($carrera->id, $apuestaPolla->carrera_id);
    }
}
