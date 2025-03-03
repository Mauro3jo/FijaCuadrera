<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ApuestaPollaUser;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserApuestaPollaUsersTest extends TestCase
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
    public function it_gets_user_apuesta_polla_users(): void
    {
        $user = User::factory()->create();
        $apuestaPollaUsers = ApuestaPollaUser::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.apuesta-polla-users.index', $user)
        );

        $response
            ->assertOk()
            ->assertSee($apuestaPollaUsers[0]->Resultadoapuesta);
    }

    /**
     * @test
     */
    public function it_stores_the_user_apuesta_polla_users(): void
    {
        $user = User::factory()->create();
        $data = ApuestaPollaUser::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.apuesta-polla-users.store', $user),
            $data
        );

        $this->assertDatabaseHas('apuesta_polla_users', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $apuestaPollaUser = ApuestaPollaUser::latest('id')->first();

        $this->assertEquals($user->id, $apuestaPollaUser->user_id);
    }
}
