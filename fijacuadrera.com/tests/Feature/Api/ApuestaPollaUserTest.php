<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ApuestaPollaUser;

use App\Models\Caballo;
use App\Models\ApuestaPolla;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApuestaPollaUserTest extends TestCase
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
    public function it_gets_apuesta_polla_users_list(): void
    {
        $apuestaPollaUsers = ApuestaPollaUser::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.apuesta-polla-users.index'));

        $response
            ->assertOk()
            ->assertSee($apuestaPollaUsers[0]->Resultadoapuesta);
    }

    /**
     * @test
     */
    public function it_stores_the_apuesta_polla_user(): void
    {
        $data = ApuestaPollaUser::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.apuesta-polla-users.store'),
            $data
        );

        $this->assertDatabaseHas('apuesta_polla_users', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_apuesta_polla_user(): void
    {
        $apuestaPollaUser = ApuestaPollaUser::factory()->create();

        $apuestaPolla = ApuestaPolla::factory()->create();
        $user = User::factory()->create();
        $caballo = Caballo::factory()->create();

        $data = [
            'Resultadoapuesta' => $this->faker->text(255),
            'apuesta_polla_id' => $apuestaPolla->id,
            'user_id' => $user->id,
            'caballo_id' => $caballo->id,
        ];

        $response = $this->putJson(
            route('api.apuesta-polla-users.update', $apuestaPollaUser),
            $data
        );

        $data['id'] = $apuestaPollaUser->id;

        $this->assertDatabaseHas('apuesta_polla_users', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_apuesta_polla_user(): void
    {
        $apuestaPollaUser = ApuestaPollaUser::factory()->create();

        $response = $this->deleteJson(
            route('api.apuesta-polla-users.destroy', $apuestaPollaUser)
        );

        $this->assertModelMissing($apuestaPollaUser);

        $response->assertNoContent();
    }
}
