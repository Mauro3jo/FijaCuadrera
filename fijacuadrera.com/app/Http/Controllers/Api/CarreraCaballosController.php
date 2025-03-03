<?php
namespace App\Http\Controllers\Api;

use App\Models\Carrera;
use App\Models\Caballo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CaballoCollection;

class CarreraCaballosController extends Controller
{
    public function index(Request $request, Carrera $carrera): CaballoCollection
    {
        $this->authorize('view', $carrera);

        $search = $request->get('search', '');

        $caballos = $carrera
            ->caballos()
            ->search($search)
            ->latest()
            ->paginate();

        return new CaballoCollection($caballos);
    }

    public function store(
        Request $request,
        Carrera $carrera,
        Caballo $caballo
    ): Response {
        $this->authorize('update', $carrera);

        $carrera->caballos()->syncWithoutDetaching([$caballo->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Carrera $carrera,
        Caballo $caballo
    ): Response {
        $this->authorize('update', $carrera);

        $carrera->caballos()->detach($caballo);

        return response()->noContent();
    }
}
