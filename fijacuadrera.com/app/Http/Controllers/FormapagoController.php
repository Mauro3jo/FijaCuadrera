<?php

namespace App\Http\Controllers;

use App\Models\Formapago;
use App\Models\Contacto;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\FormapagoStoreRequest;
use App\Http\Requests\FormapagoUpdateRequest;

class FormapagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Formapago::class);

        $search = $request->get('search', '');

        $formapagos = Formapago::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.formapagos.index', compact('formapagos', 'search'));
    }
    public function cargarSaldo()
    {
        $formapagos = Formapago::all();
        $contactos = Contacto::all();

        return view('CargarSaldo', ['formapagos' => $formapagos, 'contactos' => $contactos]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Formapago::class);

        return view('app.formapagos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormapagoStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Formapago::class);

        $validated = $request->validated();

        $formapago = Formapago::create($validated);

        return redirect()
            ->route('formapagos.edit', $formapago)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Formapago $formapago): View
    {
        $this->authorize('view', $formapago);

        return view('app.formapagos.show', compact('formapago'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Formapago $formapago): View
    {
        $this->authorize('update', $formapago);

        return view('app.formapagos.edit', compact('formapago'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        FormapagoUpdateRequest $request,
        Formapago $formapago
    ): RedirectResponse {
        $this->authorize('update', $formapago);

        $validated = $request->validated();

        $formapago->update($validated);

        return redirect()
            ->route('formapagos.edit', $formapago)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Formapago $formapago
    ): RedirectResponse {
        $this->authorize('delete', $formapago);

        $formapago->delete();

        return redirect()
            ->route('formapagos.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
