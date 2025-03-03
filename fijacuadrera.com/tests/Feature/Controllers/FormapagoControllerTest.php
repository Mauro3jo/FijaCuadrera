<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Formapago;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormapagoControllerTest extends TestCase
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
    public function it_displays_index_view_with_formapagos(): void
    {
        $formapagos = Formapago::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('formapagos.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.formapagos.index')
            ->assertViewHas('formapagos');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_formapago(): void
    {
        $response = $this->get(route('formapagos.create'));

        $response->assertOk()->assertViewIs('app.formapagos.create');
    }

    /**
     * @test
     */
    public function it_stores_the_formapago(): void
    {
        $data = Formapago::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('formapagos.store'), $data);

        $this->assertDatabaseHas('formapagos', $data);

        $formapago = Formapago::latest('id')->first();

        $response->assertRedirect(route('formapagos.edit', $formapago));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_formapago(): void
    {
        $formapago = Formapago::factory()->create();

        $response = $this->get(route('formapagos.show', $formapago));

        $response
            ->assertOk()
            ->assertViewIs('app.formapagos.show')
            ->assertViewHas('formapago');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_formapago(): void
    {
        $formapago = Formapago::factory()->create();

        $response = $this->get(route('formapagos.edit', $formapago));

        $response
            ->assertOk()
            ->assertViewIs('app.formapagos.edit')
            ->assertViewHas('formapago');
    }

    /**
     * @test
     */
    public function it_updates_the_formapago(): void
    {
        $formapago = Formapago::factory()->create();

        $data = [
            'cbu' => $this->faker->randomNumber(2),
            'alias' => $this->faker->word(255),
        ];

        $response = $this->put(route('formapagos.update', $formapago), $data);

        $data['id'] = $formapago->id;

        $this->assertDatabaseHas('formapagos', $data);

        $response->assertRedirect(route('formapagos.edit', $formapago));
    }

    /**
     * @test
     */
    public function it_deletes_the_formapago(): void
    {
        $formapago = Formapago::factory()->create();

        $response = $this->delete(route('formapagos.destroy', $formapago));

        $response->assertRedirect(route('formapagos.index'));

        $this->assertModelMissing($formapago);
    }
}
