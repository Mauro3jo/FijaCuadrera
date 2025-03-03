<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ContactoStoreRequest;
use App\Http\Requests\ContactoUpdateRequest;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Contacto::class);

        $search = $request->get('search', '');

        $contactos = Contacto::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.contactos.index', compact('contactos', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Contacto::class);

        return view('app.contactos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactoStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Contacto::class);

        $validated = $request->validated();

        $contacto = Contacto::create($validated);

        return redirect()
            ->route('contactos.edit', $contacto)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Contacto $contacto): View
    {
        $this->authorize('view', $contacto);

        return view('app.contactos.show', compact('contacto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Contacto $contacto): View
    {
        $this->authorize('update', $contacto);

        return view('app.contactos.edit', compact('contacto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ContactoUpdateRequest $request,
        Contacto $contacto
    ): RedirectResponse {
        $this->authorize('update', $contacto);

        $validated = $request->validated();

        $contacto->update($validated);

        return redirect()
            ->route('contactos.edit', $contacto)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Contacto $contacto
    ): RedirectResponse {
        $this->authorize('delete', $contacto);

        $contacto->delete();

        return redirect()
            ->route('contactos.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
