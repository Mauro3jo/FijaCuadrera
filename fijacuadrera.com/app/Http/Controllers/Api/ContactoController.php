<?php

namespace App\Http\Controllers\Api;

use App\Models\Contacto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactoResource;
use App\Http\Resources\ContactoCollection;
use App\Http\Requests\ContactoStoreRequest;
use App\Http\Requests\ContactoUpdateRequest;

class ContactoController extends Controller
{
    public function index(Request $request): ContactoCollection
    {
        $this->authorize('view-any', Contacto::class);

        $search = $request->get('search', '');

        $contactos = Contacto::search($search)
            ->latest()
            ->paginate();

        return new ContactoCollection($contactos);
    }

    public function store(ContactoStoreRequest $request): ContactoResource
    {
        $this->authorize('create', Contacto::class);

        $validated = $request->validated();

        $contacto = Contacto::create($validated);

        return new ContactoResource($contacto);
    }

    public function show(Request $request, Contacto $contacto): ContactoResource
    {
        $this->authorize('view', $contacto);

        return new ContactoResource($contacto);
    }

    public function update(
        ContactoUpdateRequest $request,
        Contacto $contacto
    ): ContactoResource {
        $this->authorize('update', $contacto);

        $validated = $request->validated();

        $contacto->update($validated);

        return new ContactoResource($contacto);
    }

    public function destroy(Request $request, Contacto $contacto): Response
    {
        $this->authorize('delete', $contacto);

        $contacto->delete();

        return response()->noContent();
    }
}
