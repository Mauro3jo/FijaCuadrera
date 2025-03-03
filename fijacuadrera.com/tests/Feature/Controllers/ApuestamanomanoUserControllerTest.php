<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ApuestamanomanoUser;

use App\Models\Caballo;
use App\Models\Apuestamanomano;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApuestamanomanoUserControllerTest extends TestCase
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
    public function it_displays_index_view_with_apuestamanomano_users(): void
    {
        $apuestamanomanoUsers = ApuestamanomanoUser::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('apuestamanomano-users.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.apuestamanomano_users.index')
            ->assertViewHas('apuestamanomanoUsers');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_apuestamanomano_user(): void
    {
        $response = $this->get(route('apuestamanomano-users.create'));

        $response->assertOk()->assertViewIs('app.apuestamanomano_users.create');
    }

    /**
     * @test
     */
    public function it_stores_the_apuestamanomano_user(): void
    {
        $data = ApuestamanomanoUser::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('apuestamanomano-users.store'), $data);

        $this->assertDatabaseHas('apuestamanomano_users', $data);

        $apuestamanomanoUser = ApuestamanomanoUser::latest('id')->first();

        $response->assertRedirect(
            route('apuestamanomano-users.edit', $apuestamanomanoUser)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_apuestamanomano_user(): void
    {
        $apuestamanomanoUser = ApuestamanomanoUser::factory()->create();

        $response = $this->get(
            route('apuestamanomano-users.show', $apuestamanomanoUser)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.apuestamanomano_users.show')
            ->assertViewHas('apuestamanomanoUser');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_apuestamanomano_user(): void
    {
        $apuestamanomanoUser = ApuestamanomanoUser::factory()->create();

        $response = $this->get(
            route('apuestamanomano-users.edit', $apuestamanomanoUser)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.apuestamanomano_users.edit')
            ->assertViewHas('apuestamanomanoUser');
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

        $response = $this->put(
            route('apuestamanomano-users.update', $apuestamanomanoUser),
            $data
        );

        $data['id'] = $apuestamanomanoUser->id;

        $this->assertDatabaseHas('apuestamanomano_users', $data);

        $response->assertRedirect(
            route('apuestamanomano-users.edit', $apuestamanomanoUser)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_apuestamanomano_user(): void
    {
        $apuestamanomanoUser = ApuestamanomanoUser::factory()->create();

        $response = $this->delete(
            route('apuestamanomano-users.destroy', $apuestamanomanoUser)
        );

        $response->assertRedirect(route('apuestamanomano-users.index'));

        $this->assertModelMissing($apuestamanomanoUser);
    }
}
