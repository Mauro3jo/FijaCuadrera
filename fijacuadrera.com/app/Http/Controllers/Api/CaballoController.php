<?php

namespace App\Http\Controllers\Api;

use App\Models\Caballo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CaballoResource;
use App\Http\Resources\CaballoCollection;
use App\Http\Requests\CaballoStoreRequest;
use App\Http\Requests\CaballoUpdateRequest;

class CaballoController extends Controller
{
    public function index(Request $request): CaballoCollection
    {
        $this->authorize('view-any', Caballo::class);

        $search = $request->get('search', '');

        $caballos = Caballo::search($search)
            ->latest()
            ->paginate();

        return new CaballoCollection($caballos);
    }

    public function store(CaballoStoreRequest $request): CaballoResource
    {
        $this->authorize('create', Caballo::class);

        $validated = $request->validated();

        $caballo = Caballo::create($validated);

        return new CaballoResource($caballo);
    }

    public function show(Request $request, Caballo $caballo): CaballoResource
    {
        $this->authorize('view', $caballo);

        return new CaballoResource($caballo);
    }

    public function update(
        CaballoUpdateRequest $request,
        Caballo $caballo
    ): CaballoResource {
        $this->authorize('update', $caballo);

        $validated = $request->validated();

        $caballo->update($validated);

        return new CaballoResource($caballo);
    }

    public function destroy(Request $request, Caballo $caballo): Response
    {
        $this->authorize('delete', $caballo);

        $caballo->delete();

        return response()->noContent();
    }
}
