<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Apuestamanomano;

use App\Models\Carrera;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApuestamanomanoControllerTest extends TestCase
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
    public function it_displays_index_view_with_apuestamanomanos(): void
    {
        $apuestamanomanos = Apuestamanomano::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('apuestamanomanos.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.apuestamanomanos.index')
            ->assertViewHas('apuestamanomanos');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_apuestamanomano(): void
    {
        $response = $this->get(route('apuestamanomanos.create'));

        $response->assertOk()->assertViewIs('app.apuestamanomanos.create');
    }

    /**
     * @test
     */
    public function it_stores_the_apuestamanomano(): void
    {
        $data = Apuestamanomano::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('apuestamanomanos.store'), $data);

        unset($data['Monto1']);
        unset($data['Monto2']);

        $this->assertDatabaseHas('apuestamanomanos', $data);

        $apuestamanomano = Apuestamanomano::latest('id')->first();

        $response->assertRedirect(
            route('apuestamanomanos.edit', $apuestamanomano)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_apuestamanomano(): void
    {
        $apuestamanomano = Apuestamanomano::factory()->create();

        $response = $this->get(
            route('apuestamanomanos.show', $apuestamanomano)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.apuestamanomanos.show')
            ->assertViewHas('apuestamanomano');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_apuestamanomano(): void
    {
        $apuestamanomano = Apuestamanomano::factory()->create();

        $response = $this->get(
            route('apuestamanomanos.edit', $apuestamanomano)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.apuestamanomanos.edit')
            ->assertViewHas('apuestamanomano');
    }

    /**
     * @test
     */
    public function it_updates_the_apuestamanomano(): void
    {
        $apuestamanomano = Apuestamanomano::factory()->create();

        $carrera = Carrera::factory()->create();

        $data = [
            'Ganancia' => $this->faker->randomNumber(2),
            'Caballo1' => $this->faker->text(255),
            'Caballo2' => $this->faker->text(255),
            'Monto1' => $this->faker->randomNumber(2),
            'Monto2' => $this->faker->randomNumber(2),
            'Tipo' => $this->faker->text(255),
            'Estado' => $this->faker->boolean(),
            'carrera_id' => $carrera->id,
        ];

        $response = $this->put(
            route('apuestamanomanos.update', $apuestamanomano),
            $data
        );

        unset($data['Monto1']);
        unset($data['Monto2']);

        $data['id'] = $apuestamanomano->id;

        $this->assertDatabaseHas('apuestamanomanos', $data);

        $response->assertRedirect(
            route('apuestamanomanos.edit', $apuestamanomano)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_apuestamanomano(): void
    {
        $apuestamanomano = Apuestamanomano::factory()->create();

        $response = $this->delete(
            route('apuestamanomanos.destroy', $apuestamanomano)
        );

        $response->assertRedirect(route('apuestamanomanos.index'));

        $this->assertModelMissing($apuestamanomano);
    }
}
