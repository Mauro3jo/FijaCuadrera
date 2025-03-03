<?php

namespace App\Http\Controllers;

use App\Models\Caballo;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CaballoStoreRequest;
use App\Http\Requests\CaballoUpdateRequest;

class CaballoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Caballo::class);

        $search = $request->get('search', '');

        $caballos = Caballo::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.caballos.index', compact('caballos', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Caballo::class);

        return view('app.caballos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        // Validar los datos del request
        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|file|image|max:2048',
            'edad' => 'required|numeric|max:255',
            'Raza' => 'required|string|max:255',
        ]);

        // Obtener el archivo de imagen del request
        $image = $request->file('imagen');

        // Si hay una imagen, guardarla en el disco público y obtener la ruta
        if ($image) {
            $path = $image->store('public/images');
        } else {
            // Si no hay una imagen, usar una ruta vacía o una por defecto
            $path = '';
        }

        // Crear un nuevo caballo con los datos del request y la ruta de la imagen
        Caballo::create([
            'nombre' => $request->input('nombre'),
            'imagen' => $path, // Aquí guardas la ruta en el campo imagen
            'edad' => $request->input('edad'),
            'Raza' => $request->input('Raza'),
        ]);

        // Redirigir a la vista de éxito o de lista de caballos
        return redirect()->route('caballos.index')->with('success', 'Caballo creado con éxito.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Caballo $caballo): View
    {
        $this->authorize('view', $caballo);

        return view('app.caballos.show', compact('caballo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Caballo $caballo): View
    {
        $this->authorize('update', $caballo);

        return view('app.caballos.edit', compact('caballo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        CaballoUpdateRequest $request,
        Caballo $caballo
    ): RedirectResponse {
        $this->authorize('update', $caballo);

        $validated = $request->validated();

        $caballo->update($validated);

        return redirect()
            ->route('caballos.edit', $caballo)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Caballo $caballo
    ): RedirectResponse {
        $this->authorize('delete', $caballo);

        $caballo->delete();

        return redirect()
            ->route('caballos.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
