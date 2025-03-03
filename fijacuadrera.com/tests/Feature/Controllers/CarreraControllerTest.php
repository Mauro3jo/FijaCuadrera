<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Carrera;

use App\Models\Hipico;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarreraControllerTest extends TestCase
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
    public function it_displays_index_view_with_carreras(): void
    {
        $carreras = Carrera::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('carreras.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.carreras.index')
            ->assertViewHas('carreras');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_carrera(): void
    {
        $response = $this->get(route('carreras.create'));

        $response->assertOk()->assertViewIs('app.carreras.create');
    }

    /**
     * @test
     */
    public function it_stores_the_carrera(): void
    {
        $data = Carrera::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('carreras.store'), $data);

        unset($data['estado']);

        $this->assertDatabaseHas('carreras', $data);

        $carrera = Carrera::latest('id')->first();

        $response->assertRedirect(route('carreras.edit', $carrera));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_carrera(): void
    {
        $carrera = Carrera::factory()->create();

        $response = $this->get(route('carreras.show', $carrera));

        $response
            ->assertOk()
            ->assertViewIs('app.carreras.show')
            ->assertViewHas('carrera');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_carrera(): void
    {
        $carrera = Carrera::factory()->create();

        $response = $this->get(route('carreras.edit', $carrera));

        $response
            ->assertOk()
            ->assertViewIs('app.carreras.edit')
            ->assertViewHas('carrera');
    }

    /**
     * @test
     */
    public function it_updates_the_carrera(): void
    {
        $carrera = Carrera::factory()->create();

        $hipico = Hipico::factory()->create();

        $data = [
            'nombre' => $this->faker->word(255),
            'fecha' => $this->faker->dateTime(),
            'estado' => $this->faker->boolean(),
            'hipico_id' => $hipico->id,
        ];

        $response = $this->put(route('carreras.update', $carrera), $data);

        unset($data['estado']);

        $data['id'] = $carrera->id;

        $this->assertDatabaseHas('carreras', $data);

        $response->assertRedirect(route('carreras.edit', $carrera));
    }

    /**
     * @test
     */
    public function it_deletes_the_carrera(): void
    {
        $carrera = Carrera::factory()->create();

        $response = $this->delete(route('carreras.destroy', $carrera));

        $response->assertRedirect(route('carreras.index'));

        $this->assertModelMissing($carrera);
    }
}
