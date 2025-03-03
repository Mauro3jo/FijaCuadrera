<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Hipico;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HipicoTest extends TestCase
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
    public function it_gets_hipicos_list(): void
    {
        $hipicos = Hipico::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.hipicos.index'));

        $response->assertOk()->assertSee($hipicos[0]->nombre);
    }

    /**
     * @test
     */
    public function it_stores_the_hipico(): void
    {
        $data = Hipico::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.hipicos.store'), $data);

        $this->assertDatabaseHas('hipicos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_hipico(): void
    {
        $hipico = Hipico::factory()->create();

        $data = [
            'nombre' => $this->faker->word(255),
            'direccion' => $this->faker->word(255),
        ];

        $response = $this->putJson(route('api.hipicos.update', $hipico), $data);

        $data['id'] = $hipico->id;

        $this->assertDatabaseHas('hipicos', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_hipico(): void
    {
        $hipico = Hipico::factory()->create();

        $response = $this->deleteJson(route('api.hipicos.destroy', $hipico));

        $this->assertModelMissing($hipico);

        $response->assertNoContent();
    }
}
