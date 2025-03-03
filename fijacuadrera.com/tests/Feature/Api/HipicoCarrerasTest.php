<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Hipico;
use App\Models\Carrera;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HipicoCarrerasTest extends TestCase
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
    public function it_gets_hipico_carreras(): void
    {
        $hipico = Hipico::factory()->create();
        $carreras = Carrera::factory()
            ->count(2)
            ->create([
                'hipico_id' => $hipico->id,
            ]);

        $response = $this->getJson(
            route('api.hipicos.carreras.index', $hipico)
        );

        $response->assertOk()->assertSee($carreras[0]->nombre);
    }

    /**
     * @test
     */
    public function it_stores_the_hipico_carreras(): void
    {
        $hipico = Hipico::factory()->create();
        $data = Carrera::factory()
            ->make([
                'hipico_id' => $hipico->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.hipicos.carreras.store', $hipico),
            $data
        );

        unset($data['estado']);

        $this->assertDatabaseHas('carreras', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $carrera = Carrera::latest('id')->first();

        $this->assertEquals($hipico->id, $carrera->hipico_id);
    }
}
