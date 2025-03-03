<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ApuestaPollaUser;

use App\Models\Caballo;
use App\Models\ApuestaPolla;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApuestaPollaUserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_apuesta_polla_users(): void
    {
        $apuestaPollaUsers = ApuestaPollaUser::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('apuesta-polla-users.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.apuesta_polla_users.index')
            ->assertViewHas('apuestaPollaUsers');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_apuesta_polla_user(): void
    {
        $response = $this->get(route('apuesta-polla-users.create'));

        $response->assertOk()->assertViewIs('app.apuesta_polla_users.create');
    }

    /**
     * @test
     */
    public function it_stores_the_apuesta_polla_user(): void
    {
        $data = ApuestaPollaUser::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('apuesta-polla-users.store'), $data);

        $this->assertDatabaseHas('apuesta_polla_users', $data);

        $apuestaPollaUser = ApuestaPollaUser::latest('id')->first();

        $response->assertRedirect(
            route('apuesta-polla-users.edit', $apuestaPollaUser)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_apuesta_polla_user(): void
    {
        $apuestaPollaUser = ApuestaPollaUser::factory()->create();

        $response = $this->get(
            route('apuesta-polla-users.show', $apuestaPollaUser)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.apuesta_polla_users.show')
            ->assertViewHas('apuestaPollaUser');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_apuesta_polla_user(): void
    {
        $apuestaPollaUser = ApuestaPollaUser::factory()->create();

        $response = $this->get(
            route('apuesta-polla-users.edit', $apuestaPollaUser)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.apuesta_polla_users.edit')
            ->assertViewHas('apuestaPollaUser');
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

        $response = $this->put(
            route('apuesta-polla-users.update', $apuestaPollaUser),
            $data
        );

        $data['id'] = $apuestaPollaUser->id;

        $this->assertDatabaseHas('apuesta_polla_users', $data);

        $response->assertRedirect(
            route('apuesta-polla-users.edit', $apuestaPollaUser)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_apuesta_polla_user(): void
    {
        $apuestaPollaUser = ApuestaPollaUser::factory()->create();

        $response = $this->delete(
            route('apuesta-polla-users.destroy', $apuestaPollaUser)
        );

        $response->assertRedirect(route('apuesta-polla-users.index'));

        $this->assertModelMissing($apuestaPollaUser);
    }
}
