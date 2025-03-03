<?php

namespace App\Http\Controllers\Api;

use App\Models\Carrera;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApuestaPollaResource;
use App\Http\Resources\ApuestaPollaCollection;

class CarreraApuestaPollasController extends Controller
{
    public function index(
        Request $request,
        Carrera $carrera
    ): ApuestaPollaCollection {
        $this->authorize('view', $carrera);

        $search = $request->get('search', '');

        $apuestaPollas = $carrera
            ->apuestaPollas()
            ->search($search)
            ->latest()
            ->paginate();

        return new ApuestaPollaCollection($apuestaPollas);
    }

    public function store(
        Request $request,
        Carrera $carrera
    ): ApuestaPollaResource {
        $this->authorize('create', ApuestaPolla::class);

        $validated = $request->validate([
            'Ganancia' => ['required', 'numeric'],
            'Caballo1' => ['required', 'max:255', 'string'],
            'Monto1' => ['required', 'numeric'],
            'Caballo2' => ['required', 'max:255', 'string'],
            'Monto2' => ['required', 'numeric'],
            'Caballo3' => ['required', 'max:255', 'string'],
            'Monto3' => ['required', 'numeric'],
            'Caballo4' => ['required', 'max:255', 'string'],
            'Monto4' => ['required', 'numeric'],
            'Caballo5' => ['required', 'max:255', 'string'],
            'Monto5' => ['required', 'numeric'],
            'Estado' => ['required', 'boolean'],
        ]);

        $apuestaPolla = $carrera->apuestaPollas()->create($validated);

        return new ApuestaPollaResource($apuestaPolla);
    }
}
