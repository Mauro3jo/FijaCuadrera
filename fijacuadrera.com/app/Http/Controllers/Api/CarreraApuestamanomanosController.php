<?php

namespace App\Http\Controllers\Api;

use App\Models\Carrera;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApuestamanomanoResource;
use App\Http\Resources\ApuestamanomanoCollection;

class CarreraApuestamanomanosController extends Controller
{
    public function index(
        Request $request,
        Carrera $carrera
    ): ApuestamanomanoCollection {
        $this->authorize('view', $carrera);

        $search = $request->get('search', '');

        $apuestamanomanos = $carrera
            ->apuestamanomanos()
            ->search($search)
            ->latest()
            ->paginate();

        return new ApuestamanomanoCollection($apuestamanomanos);
    }

    public function store(
        Request $request,
        Carrera $carrera
    ): ApuestamanomanoResource {
        $this->authorize('create', Apuestamanomano::class);

        $validated = $request->validate([
            'Ganancia' => ['required', 'numeric'],
            'Caballo1' => ['required', 'max:255', 'string'],
            'Caballo2' => ['required', 'max:255', 'string'],
            'Tipo' => ['required', 'max:255', 'string'],
            'Estado' => ['required', 'boolean'],
        ]);

        $apuestamanomano = $carrera->apuestamanomanos()->create($validated);

        return new ApuestamanomanoResource($apuestamanomano);
    }
}
