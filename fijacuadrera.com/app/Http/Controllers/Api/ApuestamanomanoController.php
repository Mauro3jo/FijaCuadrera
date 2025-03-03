<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Apuestamanomano;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApuestamanomanoResource;
use App\Http\Resources\ApuestamanomanoCollection;
use App\Http\Requests\ApuestamanomanoStoreRequest;
use App\Http\Requests\ApuestamanomanoUpdateRequest;

class ApuestamanomanoController extends Controller
{
    public function index(Request $request): ApuestamanomanoCollection
    {
        $this->authorize('view-any', Apuestamanomano::class);

        $search = $request->get('search', '');

        $apuestamanomanos = Apuestamanomano::search($search)
            ->latest()
            ->paginate();

        return new ApuestamanomanoCollection($apuestamanomanos);
    }

    public function store(
        ApuestamanomanoStoreRequest $request
    ): ApuestamanomanoResource {
        $this->authorize('create', Apuestamanomano::class);

        $validated = $request->validated();

        $apuestamanomano = Apuestamanomano::create($validated);

        return new ApuestamanomanoResource($apuestamanomano);
    }

    public function show(
        Request $request,
        Apuestamanomano $apuestamanomano
    ): ApuestamanomanoResource {
        $this->authorize('view', $apuestamanomano);

        return new ApuestamanomanoResource($apuestamanomano);
    }

    public function update(
        ApuestamanomanoUpdateRequest $request,
        Apuestamanomano $apuestamanomano
    ): ApuestamanomanoResource {
        $this->authorize('update', $apuestamanomano);

        $validated = $request->validated();

        $apuestamanomano->update($validated);

        return new ApuestamanomanoResource($apuestamanomano);
    }

    public function destroy(
        Request $request,
        Apuestamanomano $apuestamanomano
    ): Response {
        $this->authorize('delete', $apuestamanomano);

        $apuestamanomano->delete();

        return response()->noContent();
    }
}
