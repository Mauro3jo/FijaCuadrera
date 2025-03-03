<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ApuestaPolla;

use App\Models\Carrera;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApuestaPollaTest extends TestCase
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
    public function it_gets_apuesta_pollas_list(): void
    {
        $apuestaPollas = ApuestaPolla::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.apuesta-pollas.index'));

        $response->assertOk()->assertSee($apuestaPollas[0]->Caballo1);
    }

    /**
     * @test
     */
    public function it_stores_the_apuesta_polla(): void
    {
        $data = ApuestaPolla::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.apuesta-pollas.store'), $data);

        $this->assertDatabaseHas('apuesta_pollas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_apuesta_polla(): void
    {
        $apuestaPolla = ApuestaPolla::factory()->create();

        $carrera = Carrera::factory()->create();

        $data = [
            'Ganancia' => $this->faker->randomNumber(2),
            'Caballo1' => $this->faker->text(255),
            'Monto1' => $this->faker->randomNumber(2),
            'Caballo2' => $this->faker->text(255),
            'Monto2' => $this->faker->randomNumber(2),
            'Caballo3' => $this->faker->text(255),
            'Monto3' => $this->faker->randomNumber(2),
            'Caballo4' => $this->faker->text(255),
            'Monto4' => $this->faker->randomNumber(2),
            'Caballo5' => $this->faker->text(255),
            'Monto5' => $this->faker->randomNumber(2),
            'Estado' => $this->faker->boolean(),
            'carrera_id' => $carrera->id,
        ];

        $response = $this->putJson(
            route('api.apuesta-pollas.update', $apuestaPolla),
            $data
        );

        $data['id'] = $apuestaPolla->id;

        $this->assertDatabaseHas('apuesta_pollas', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_apuesta_polla(): void
    {
        $apuestaPolla = ApuestaPolla::factory()->create();

        $response = $this->deleteJson(
            route('api.apuesta-pollas.destroy', $apuestaPolla)
        );

        $this->assertModelMissing($apuestaPolla);

        $response->assertNoContent();
    }
}
