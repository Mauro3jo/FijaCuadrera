<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Caballo;
use App\Models\ApuestamanomanoUser;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CaballoApuestamanomanoUsersTest extends TestCase
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
    public function it_gets_caballo_apuestamanomano_users(): void
    {
        $caballo = Caballo::factory()->create();
        $apuestamanomanoUsers = ApuestamanomanoUser::factory()
            ->count(2)
            ->create([
                'caballo_id' => $caballo->id,
            ]);

        $response = $this->getJson(
            route('api.caballos.apuestamanomano-users.index', $caballo)
        );

        $response
            ->assertOk()
            ->assertSee($apuestamanomanoUsers[0]->resultadoapuesta);
    }

    /**
     * @test
     */
    public function it_stores_the_caballo_apuestamanomano_users(): void
    {
        $caballo = Caballo::factory()->create();
        $data = ApuestamanomanoUser::factory()
            ->make([
                'caballo_id' => $caballo->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.caballos.apuestamanomano-users.store', $caballo),
            $data
        );

        $this->assertDatabaseHas('apuestamanomano_users', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $apuestamanomanoUser = ApuestamanomanoUser::latest('id')->first();

        $this->assertEquals($caballo->id, $apuestamanomanoUser->caballo_id);
    }
}
