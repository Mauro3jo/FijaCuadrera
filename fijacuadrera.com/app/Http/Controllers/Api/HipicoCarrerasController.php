<?php

namespace App\Http\Controllers\Api;

use App\Models\Hipico;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CarreraResource;
use App\Http\Resources\CarreraCollection;

class HipicoCarrerasController extends Controller
{
    public function index(Request $request, Hipico $hipico): CarreraCollection
    {
        $this->authorize('view', $hipico);

        $search = $request->get('search', '');

        $carreras = $hipico
            ->carreras()
            ->search($search)
            ->latest()
            ->paginate();

        return new CarreraCollection($carreras);
    }

    public function store(Request $request, Hipico $hipico): CarreraResource
    {
        $this->authorize('create', Carrera::class);

        $validated = $request->validate([
            'nombre' => ['required', 'max:255'],
            'fecha' => ['required', 'date'],
        ]);

        $carrera = $hipico->carreras()->create($validated);

        return new CarreraResource($carrera);
    }
}
