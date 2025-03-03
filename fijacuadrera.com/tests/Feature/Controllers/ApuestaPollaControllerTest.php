<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ApuestaPolla;

use App\Models\Carrera;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApuestaPollaControllerTest extends TestCase
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
    public function it_displays_index_view_with_apuesta_pollas(): void
    {
        $apuestaPollas = ApuestaPolla::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('apuesta-pollas.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.apuesta_pollas.index')
            ->assertViewHas('apuestaPollas');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_apuesta_polla(): void
    {
        $response = $this->get(route('apuesta-pollas.create'));

        $response->assertOk()->assertViewIs('app.apuesta_pollas.create');
    }

    /**
     * @test
     */
    public function it_stores_the_apuesta_polla(): void
    {
        $data = ApuestaPolla::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('apuesta-pollas.store'), $data);

        $this->assertDatabaseHas('apuesta_pollas', $data);

        $apuestaPolla = ApuestaPolla::latest('id')->first();

        $response->assertRedirect(route('apuesta-pollas.edit', $apuestaPolla));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_apuesta_polla(): void
    {
        $apuestaPolla = ApuestaPolla::factory()->create();

        $response = $this->get(route('apuesta-pollas.show', $apuestaPolla));

        $response
            ->assertOk()
            ->assertViewIs('app.apuesta_pollas.show')
            ->assertViewHas('apuestaPolla');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_apuesta_polla(): void
    {
        $apuestaPolla = ApuestaPolla::factory()->create();

        $response = $this->get(route('apuesta-pollas.edit', $apuestaPolla));

        $response
            ->assertOk()
            ->assertViewIs('app.apuesta_pollas.edit')
            ->assertViewHas('apuestaPolla');
    }

    /**
     * @test
     */
    public function it_updates_the_apuesta_polla(): void
    {
        $apuestaPolla = ApuestaPolla::factory()->create();

        $carrera = Carrera::factory()->create();

        $data = [
            'Ganancia' => $this->faker->randomNumber(2),
            'Caballo1' => $this->faker->text(255),
            'Monto1' => $this->faker->randomNumber(2),
            'Caballo2' => $this->faker->text(255),
            'Monto2' => $this->faker->randomNumber(2),
            'Caballo3' => $this->faker->text(255),
            'Monto3' => $this->faker->randomNumber(2),
            'Caballo4' => $this->faker->text(255),
            'Monto4' => $this->faker->randomNumber(2),
            'Caballo5' => $this->faker->text(255),
            'Monto5' => $this->faker->randomNumber(2),
            'Estado' => $this->faker->boolean(),
            'carrera_id' => $carrera->id,
        ];

        $response = $this->put(
            route('apuesta-pollas.update', $apuestaPolla),
            $data
        );

        $data['id'] = $apuestaPolla->id;

        $this->assertDatabaseHas('apuesta_pollas', $data);

        $response->assertRedirect(route('apuesta-pollas.edit', $apuestaPolla));
    }

    /**
     * @test
     */
    public function it_deletes_the_apuesta_polla(): void
    {
        $apuestaPolla = ApuestaPolla::factory()->create();

        $response = $this->delete(
            route('apuesta-pollas.destroy', $apuestaPolla)
        );

        $response->assertRedirect(route('apuesta-pollas.index'));

        $this->assertModelMissing($apuestaPolla);
    }
}
