<?php

namespace App\Http\Controllers\Api;

use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CarreraResource;
use App\Http\Resources\CarreraCollection;
use App\Http\Requests\CarreraStoreRequest;
use App\Http\Requests\CarreraUpdateRequest;

class CarreraController extends Controller
{
    public function index(Request $request): CarreraCollection
    {
        $this->authorize('view-any', Carrera::class);

        $search = $request->get('search', '');

        $carreras = Carrera::search($search)
            ->latest()
            ->paginate();

        return new CarreraCollection($carreras);
    }

    public function store(CarreraStoreRequest $request): CarreraResource
    {
        $this->authorize('create', Carrera::class);

        $validated = $request->validated();

        $carrera = Carrera::create($validated);

        return new CarreraResource($carrera);
    }

    public function show(Request $request, Carrera $carrera): CarreraResource
    {
        $this->authorize('view', $carrera);

        return new CarreraResource($carrera);
    }

    public function update(
        CarreraUpdateRequest $request,
        Carrera $carrera
    ): CarreraResource {
        $this->authorize('update', $carrera);

        $validated = $request->validated();

        $carrera->update($validated);

        return new CarreraResource($carrera);
    }

    public function destroy(Request $request, Carrera $carrera): Response
    {
        $this->authorize('delete', $carrera);

        $carrera->delete();

        return response()->noContent();
    }
}
