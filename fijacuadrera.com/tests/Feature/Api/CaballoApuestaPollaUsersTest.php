<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Caballo;
use App\Models\ApuestaPollaUser;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CaballoApuestaPollaUsersTest extends TestCase
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
    public function it_gets_caballo_apuesta_polla_users(): void
    {
        $caballo = Caballo::factory()->create();
        $apuestaPollaUsers = ApuestaPollaUser::factory()
            ->count(2)
            ->create([
                'caballo_id' => $caballo->id,
            ]);

        $response = $this->getJson(
            route('api.caballos.apuesta-polla-users.index', $caballo)
        );

        $response
            ->assertOk()
            ->assertSee($apuestaPollaUsers[0]->Resultadoapuesta);
    }

    /**
     * @test
     */
    public function it_stores_the_caballo_apuesta_polla_users(): void
    {
        $caballo = Caballo::factory()->create();
        $data = ApuestaPollaUser::factory()
            ->make([
                'caballo_id' => $caballo->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.caballos.apuesta-polla-users.store', $caballo),
            $data
        );

        $this->assertDatabaseHas('apuesta_polla_users', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $apuestaPollaUser = ApuestaPollaUser::latest('id')->first();

        $this->assertEquals($caballo->id, $apuestaPollaUser->caballo_id);
    }
}
