<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ApuestamanomanoUser;

use App\Models\Caballo;
use App\Models\Apuestamanomano;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApuestamanomanoUserTest extends TestCase
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
    public function it_gets_apuestamanomano_users_list(): void
    {
        $apuestamanomanoUsers = ApuestamanomanoUser::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.apuestamanomano-users.index'));

        $response
            ->assertOk()
            ->assertSee($apuestamanomanoUsers[0]->resultadoapuesta);
    }

    /**
     * @test
     */
    public function it_stores_the_apuestamanomano_user(): void
    {
        $data = ApuestamanomanoUser::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.apuestamanomano-users.store'),
            $data
        );

        $this->assertDatabaseHas('apuestamanomano_users', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_apuestamanomano_user(): void
    {
        $apuestamanomanoUser = ApuestamanomanoUser::factory()->create();

        $apuestamanomano = Apuestamanomano::factory()->create();
        $user = User::factory()->create();
        $caballo = Caballo::factory()->create();

        $data = [
            'resultadoapuesta' => $this->faker->text(255),
            'apuestamanomano_id' => $apuestamanomano->id,
            'user_id' => $user->id,
            'caballo_id' => $caballo->id,
        ];

        $response = $this->putJson(
            route('api.apuestamanomano-users.update', $apuestamanomanoUser),
            $data
        );

        $data['id'] = $apuestamanomanoUser->id;

        $this->assertDatabaseHas('apuestamanomano_users', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_apuestamanomano_user(): void
    {
        $apuestamanomanoUser = ApuestamanomanoUser::factory()->create();

        $response = $this->deleteJson(
            route('api.apuestamanomano-users.destroy', $apuestamanomanoUser)
        );

        $this->assertModelMissing($apuestamanomanoUser);

        $response->assertNoContent();
    }
}
