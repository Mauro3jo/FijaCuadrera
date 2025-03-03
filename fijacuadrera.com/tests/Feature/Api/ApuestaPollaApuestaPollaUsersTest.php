<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ApuestaPolla;
use App\Models\ApuestaPollaUser;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApuestaPollaApuestaPollaUsersTest extends TestCase
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
    public function it_gets_apuesta_polla_apuesta_polla_users(): void
    {
        $apuestaPolla = ApuestaPolla::factory()->create();
        $apuestaPollaUsers = ApuestaPollaUser::factory()
            ->count(2)
            ->create([
                'apuesta_polla_id' => $apuestaPolla->id,
            ]);

        $response = $this->getJson(
            route('api.apuesta-pollas.apuesta-polla-users.index', $apuestaPolla)
        );

        $response
            ->assertOk()
            ->assertSee($apuestaPollaUsers[0]->Resultadoapuesta);
    }

    /**
     * @test
     */
    public function it_stores_the_apuesta_polla_apuesta_polla_users(): void
    {
        $apuestaPolla = ApuestaPolla::factory()->create();
        $data = ApuestaPollaUser::factory()
            ->make([
                'apuesta_polla_id' => $apuestaPolla->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.apuesta-pollas.apuesta-polla-users.store',
                $apuestaPolla
            ),
            $data
        );

        $this->assertDatabaseHas('apuesta_polla_users', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $apuestaPollaUser = ApuestaPollaUser::latest('id')->first();

        $this->assertEquals(
            $apuestaPolla->id,
            $apuestaPollaUser->apuesta_polla_id
        );
    }
}
