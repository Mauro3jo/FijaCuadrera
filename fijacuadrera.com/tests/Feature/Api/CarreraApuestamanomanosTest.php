<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Carrera;
use App\Models\Apuestamanomano;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarreraApuestamanomanosTest extends TestCase
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
    public function it_gets_carrera_apuestamanomanos(): void
    {
        $carrera = Carrera::factory()->create();
        $apuestamanomanos = Apuestamanomano::factory()
            ->count(2)
            ->create([
                'carrera_id' => $carrera->id,
            ]);

        $response = $this->getJson(
            route('api.carreras.apuestamanomanos.index', $carrera)
        );

        $response->assertOk()->assertSee($apuestamanomanos[0]->Caballo1);
    }

    /**
     * @test
     */
    public function it_stores_the_carrera_apuestamanomanos(): void
    {
        $carrera = Carrera::factory()->create();
        $data = Apuestamanomano::factory()
            ->make([
                'carrera_id' => $carrera->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.carreras.apuestamanomanos.store', $carrera),
            $data
        );

        unset($data['Monto1']);
        unset($data['Monto2']);

        $this->assertDatabaseHas('apuestamanomanos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $apuestamanomano = Apuestamanomano::latest('id')->first();

        $this->assertEquals($carrera->id, $apuestamanomano->carrera_id);
    }
}
