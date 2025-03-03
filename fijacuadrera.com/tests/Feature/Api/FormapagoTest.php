<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Formapago;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormapagoTest extends TestCase
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
    public function it_gets_formapagos_list(): void
    {
        $formapagos = Formapago::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.formapagos.index'));

        $response->assertOk()->assertSee($formapagos[0]->alias);
    }

    /**
     * @test
     */
    public function it_stores_the_formapago(): void
    {
        $data = Formapago::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.formapagos.store'), $data);

        $this->assertDatabaseHas('formapagos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_formapago(): void
    {
        $formapago = Formapago::factory()->create();

        $data = [
            'cbu' => $this->faker->randomNumber(2),
            'alias' => $this->faker->word(255),
        ];

        $response = $this->putJson(
            route('api.formapagos.update', $formapago),
            $data
        );

        $data['id'] = $formapago->id;

        $this->assertDatabaseHas('formapagos', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_formapago(): void
    {
        $formapago = Formapago::factory()->create();

        $response = $this->deleteJson(
            route('api.formapagos.destroy', $formapago)
        );

        $this->assertModelMissing($formapago);

        $response->assertNoContent();
    }
}
