<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Hipico;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\HipicoStoreRequest;
use App\Http\Requests\HipicoUpdateRequest;

class HipicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Hipico::class);

        $search = $request->get('search', '');

        $hipicos = Hipico::search($search)
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('app.hipicos.index', compact('hipicos', 'search'));
    }
    public function reuniones(Request $request): View
    {
        $this->authorize('view-any', Hipico::class);

        $search = $request->get('search', '');

        $hipicos = Hipico::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('Reuniones', compact('hipicos', 'search'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Hipico::class);

        return view('app.hipicos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HipicoStoreRequest $request): RedirectResponse
{
    $this->authorize('create', Hipico::class);

    $validated = $request->validated();

    // Si se subió una imagen, moverla a la carpeta public/imagenes y guardar la ruta en la base de datos
    if ($request->hasFile('imagen')) {
        $image = $request->file('imagen');
        $filePath = $image->move('imagenes', $image->getClientOriginalName()); // Mueve la imagen a public/imagenes con el nombre original
        $validated['imagen'] = str_replace('public/', '', $filePath); // Guarda la ruta de la imagen en la base de datos (sin "public/")
    }

    // Crear un nuevo registro de Hipico
    $hipico = Hipico::create($validated);

    return redirect()
        ->route('hipicos.index', $hipico)
        ->withSuccess(__('hipico guardado'));
}


    /**
     * Display the specified resource.
     */
    public function show(Request $request, Hipico $hipico): View
    {
        $this->authorize('view', $hipico);

        return view('app.hipicos.show', compact('hipico'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Hipico $hipico): View
    {
        $this->authorize('update', $hipico);

        return view('app.hipicos.edit', compact('hipico'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HipicoUpdateRequest $request, Hipico $hipico): RedirectResponse
{
    $this->authorize('update', $hipico);

    $validated = $request->validated();

    // Si se subió una imagen, eliminar la anterior, almacenar la nueva y guardar el nombre del archivo en la base de datos
    if ($request->hasFile('imagen')) {
        if ($hipico->imagen) {
            Storage::delete('public/' . $hipico->imagen);
        }

        $imagePath = $request->file('imagen')->store('public/imagenes');
        $validated['imagen'] = str_replace('public/', '', $imagePath);
    }

    // Actualizar los datos del hipico
    $hipico->update($validated);

    return redirect()
        ->route('hipicos.edit', $hipico)
        ->withSuccess(__('crud.common.saved'));
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Hipico $hipico): RedirectResponse
    {
        $this->authorize('delete', $hipico);

        $hipico->delete();

        return redirect()
            ->route('hipicos.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
