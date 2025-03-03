<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Caballo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CaballoControllerTest extends TestCase
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
    public function it_displays_index_view_with_caballos(): void
    {
        $caballos = Caballo::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('caballos.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.caballos.index')
            ->assertViewHas('caballos');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_caballo(): void
    {
        $response = $this->get(route('caballos.create'));

        $response->assertOk()->assertViewIs('app.caballos.create');
    }

    /**
     * @test
     */
    public function it_stores_the_caballo(): void
    {
        $data = Caballo::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('caballos.store'), $data);

        $this->assertDatabaseHas('caballos', $data);

        $caballo = Caballo::latest('id')->first();

        $response->assertRedirect(route('caballos.edit', $caballo));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_caballo(): void
    {
        $caballo = Caballo::factory()->create();

        $response = $this->get(route('caballos.show', $caballo));

        $response
            ->assertOk()
            ->assertViewIs('app.caballos.show')
            ->assertViewHas('caballo');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_caballo(): void
    {
        $caballo = Caballo::factory()->create();

        $response = $this->get(route('caballos.edit', $caballo));

        $response
            ->assertOk()
            ->assertViewIs('app.caballos.edit')
            ->assertViewHas('caballo');
    }

    /**
     * @test
     */
    public function it_updates_the_caballo(): void
    {
        $caballo = Caballo::factory()->create();

        $data = [
            'nombre' => $this->faker->word(255),
            'edad' => $this->faker->randomNumber(2),
            'Raza' => $this->faker->word(255),
        ];

        $response = $this->put(route('caballos.update', $caballo), $data);

        $data['id'] = $caballo->id;

        $this->assertDatabaseHas('caballos', $data);

        $response->assertRedirect(route('caballos.edit', $caballo));
    }

    /**
     * @test
     */
    public function it_deletes_the_caballo(): void
    {
        $caballo = Caballo::factory()->create();

        $response = $this->delete(route('caballos.destroy', $caballo));

        $response->assertRedirect(route('caballos.index'));

        $this->assertModelMissing($caballo);
    }
}
