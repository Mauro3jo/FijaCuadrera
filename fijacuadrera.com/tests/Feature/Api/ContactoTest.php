<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Contacto;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactoTest extends TestCase
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
    public function it_gets_contactos_list(): void
    {
        $contactos = Contacto::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.contactos.index'));

        $response->assertOk()->assertSee($contactos[0]->HoraDisponible);
    }

    /**
     * @test
     */
    public function it_stores_the_contacto(): void
    {
        $data = Contacto::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.contactos.store'), $data);

        $this->assertDatabaseHas('contactos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_contacto(): void
    {
        $contacto = Contacto::factory()->create();

        $data = [
            'celular' => $this->faker->randomNumber(2),
            'HoraDisponible' => $this->faker->word(255),
        ];

        $response = $this->putJson(
            route('api.contactos.update', $contacto),
            $data
        );

        $data['id'] = $contacto->id;

        $this->assertDatabaseHas('contactos', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_contacto(): void
    {
        $contacto = Contacto::factory()->create();

        $response = $this->deleteJson(
            route('api.contactos.destroy', $contacto)
        );

        $this->assertModelMissing($contacto);

        $response->assertNoContent();
    }
}
