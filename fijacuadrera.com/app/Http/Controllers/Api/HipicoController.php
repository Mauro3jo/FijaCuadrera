<?php

namespace App\Http\Controllers\Api;

use App\Models\Hipico;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\HipicoResource;
use App\Http\Resources\HipicoCollection;
use App\Http\Requests\HipicoStoreRequest;
use App\Http\Requests\HipicoUpdateRequest;

class HipicoController extends Controller
{
    public function index(Request $request): HipicoCollection
    {
        $this->authorize('view-any', Hipico::class);

        $search = $request->get('search', '');

        $hipicos = Hipico::search($search)
            ->latest()
            ->paginate();

        return new HipicoCollection($hipicos);
    }

    public function store(HipicoStoreRequest $request): HipicoResource
    {
        $this->authorize('create', Hipico::class);

        $validated = $request->validated();

        $hipico = Hipico::create($validated);

        return new HipicoResource($hipico);
    }

    public function show(Request $request, Hipico $hipico): HipicoResource
    {
        $this->authorize('view', $hipico);

        return new HipicoResource($hipico);
    }

    public function update(
        HipicoUpdateRequest $request,
        Hipico $hipico
    ): HipicoResource {
        $this->authorize('update', $hipico);

        $validated = $request->validated();

        $hipico->update($validated);

        return new HipicoResource($hipico);
    }

    public function destroy(Request $request, Hipico $hipico): Response
    {
        $this->authorize('delete', $hipico);

        $hipico->delete();

        return response()->noContent();
    }
}
