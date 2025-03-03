<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Hipico;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HipicoControllerTest extends TestCase
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
    public function it_displays_index_view_with_hipicos(): void
    {
        $hipicos = Hipico::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('hipicos.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.hipicos.index')
            ->assertViewHas('hipicos');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_hipico(): void
    {
        $response = $this->get(route('hipicos.create'));

        $response->assertOk()->assertViewIs('app.hipicos.create');
    }

    /**
     * @test
     */
    public function it_stores_the_hipico(): void
    {
        $data = Hipico::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('hipicos.store'), $data);

        $this->assertDatabaseHas('hipicos', $data);

        $hipico = Hipico::latest('id')->first();

        $response->assertRedirect(route('hipicos.edit', $hipico));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_hipico(): void
    {
        $hipico = Hipico::factory()->create();

        $response = $this->get(route('hipicos.show', $hipico));

        $response
            ->assertOk()
            ->assertViewIs('app.hipicos.show')
            ->assertViewHas('hipico');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_hipico(): void
    {
        $hipico = Hipico::factory()->create();

        $response = $this->get(route('hipicos.edit', $hipico));

        $response
            ->assertOk()
            ->assertViewIs('app.hipicos.edit')
            ->assertViewHas('hipico');
    }

    /**
     * @test
     */
    public function it_updates_the_hipico(): void
    {
        $hipico = Hipico::factory()->create();

        $data = [
            'nombre' => $this->faker->word(255),
            'direccion' => $this->faker->word(255),
        ];

        $response = $this->put(route('hipicos.update', $hipico), $data);

        $data['id'] = $hipico->id;

        $this->assertDatabaseHas('hipicos', $data);

        $response->assertRedirect(route('hipicos.edit', $hipico));
    }

    /**
     * @test
     */
    public function it_deletes_the_hipico(): void
    {
        $hipico = Hipico::factory()->create();

        $response = $this->delete(route('hipicos.destroy', $hipico));

        $response->assertRedirect(route('hipicos.index'));

        $this->assertModelMissing($hipico);
    }
}
