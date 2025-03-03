<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ApuestamanomanoUser;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserApuestamanomanoUsersTest extends TestCase
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
    public function it_gets_user_apuestamanomano_users(): void
    {
        $user = User::factory()->create();
        $apuestamanomanoUsers = ApuestamanomanoUser::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.apuestamanomano-users.index', $user)
        );

        $response
            ->assertOk()
            ->assertSee($apuestamanomanoUsers[0]->resultadoapuesta);
    }

    /**
     * @test
     */
    public function it_stores_the_user_apuestamanomano_users(): void
    {
        $user = User::factory()->create();
        $data = ApuestamanomanoUser::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.apuestamanomano-users.store', $user),
            $data
        );

        $this->assertDatabaseHas('apuestamanomano_users', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $apuestamanomanoUser = ApuestamanomanoUser::latest('id')->first();

        $this->assertEquals($user->id, $apuestamanomanoUser->user_id);
    }
}
