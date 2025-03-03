<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Contacto;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactoControllerTest extends TestCase
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
    public function it_displays_index_view_with_contactos(): void
    {
        $contactos = Contacto::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('contactos.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.contactos.index')
            ->assertViewHas('contactos');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_contacto(): void
    {
        $response = $this->get(route('contactos.create'));

        $response->assertOk()->assertViewIs('app.contactos.create');
    }

    /**
     * @test
     */
    public function it_stores_the_contacto(): void
    {
        $data = Contacto::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('contactos.store'), $data);

        $this->assertDatabaseHas('contactos', $data);

        $contacto = Contacto::latest('id')->first();

        $response->assertRedirect(route('contactos.edit', $contacto));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_contacto(): void
    {
        $contacto = Contacto::factory()->create();

        $response = $this->get(route('contactos.show', $contacto));

        $response
            ->assertOk()
            ->assertViewIs('app.contactos.show')
            ->assertViewHas('contacto');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_contacto(): void
    {
        $contacto = Contacto::factory()->create();

        $response = $this->get(route('contactos.edit', $contacto));

        $response
            ->assertOk()
            ->assertViewIs('app.contactos.edit')
            ->assertViewHas('contacto');
    }

    /**
     * @test
     */
    public function it_updates_the_contacto(): void
    {
        $contacto = Contacto::factory()->create();

        $data = [
            'celular' => $this->faker->randomNumber(2),
            'HoraDisponible' => $this->faker->word(255),
        ];

        $response = $this->put(route('contactos.update', $contacto), $data);

        $data['id'] = $contacto->id;

        $this->assertDatabaseHas('contactos', $data);

        $response->assertRedirect(route('contactos.edit', $contacto));
    }

    /**
     * @test
     */
    public function it_deletes_the_contacto(): void
    {
        $contacto = Contacto::factory()->create();

        $response = $this->delete(route('contactos.destroy', $contacto));

        $response->assertRedirect(route('contactos.index'));

        $this->assertModelMissing($contacto);
    }
}
