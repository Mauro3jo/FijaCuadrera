<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Apuestamanomano;
use App\Models\ApuestamanomanoUser;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApuestamanomanoApuestamanomanoUsersTest extends TestCase
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
    public function it_gets_apuestamanomano_apuestamanomano_users(): void
    {
        $apuestamanomano = Apuestamanomano::factory()->create();
        $apuestamanomanoUsers = ApuestamanomanoUser::factory()
            ->count(2)
            ->create([
                'apuestamanomano_id' => $apuestamanomano->id,
            ]);

        $response = $this->getJson(
            route(
                'api.apuestamanomanos.apuestamanomano-users.index',
                $apuestamanomano
            )
        );

        $response
            ->assertOk()
            ->assertSee($apuestamanomanoUsers[0]->resultadoapuesta);
    }

    /**
     * @test
     */
    public function it_stores_the_apuestamanomano_apuestamanomano_users(): void
    {
        $apuestamanomano = Apuestamanomano::factory()->create();
        $data = ApuestamanomanoUser::factory()
            ->make([
                'apuestamanomano_id' => $apuestamanomano->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.apuestamanomanos.apuestamanomano-users.store',
                $apuestamanomano
            ),
            $data
        );

        $this->assertDatabaseHas('apuestamanomano_users', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $apuestamanomanoUser = ApuestamanomanoUser::latest('id')->first();

        $this->assertEquals(
            $apuestamanomano->id,
            $apuestamanomanoUser->apuestamanomano_id
        );
    }
}
