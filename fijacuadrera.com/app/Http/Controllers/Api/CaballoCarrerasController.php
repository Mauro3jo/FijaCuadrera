<?php
namespace App\Http\Controllers\Api;

use App\Models\Caballo;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CarreraCollection;

class CaballoCarrerasController extends Controller
{
    public function index(Request $request, Caballo $caballo): CarreraCollection
    {
        $this->authorize('view', $caballo);

        $search = $request->get('search', '');

        $carreras = $caballo
            ->carreras()
            ->search($search)
            ->latest()
            ->paginate();

        return new CarreraCollection($carreras);
    }

    public function store(
        Request $request,
        Caballo $caballo,
        Carrera $carrera
    ): Response {
        $this->authorize('update', $caballo);

        $caballo->carreras()->syncWithoutDetaching([$carrera->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Caballo $caballo,
        Carrera $carrera
    ): Response {
        $this->authorize('update', $caballo);

        $caballo->carreras()->detach($carrera);

        return response()->noContent();
    }
}
