<?php

namespace App\Http\Controllers\Api;

use App\Models\Formapago;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\FormapagoResource;
use App\Http\Resources\FormapagoCollection;
use App\Http\Requests\FormapagoStoreRequest;
use App\Http\Requests\FormapagoUpdateRequest;

class FormapagoController extends Controller
{
    public function index(Request $request): FormapagoCollection
    {
        $this->authorize('view-any', Formapago::class);

        $search = $request->get('search', '');

        $formapagos = Formapago::search($search)
            ->latest()
            ->paginate();

        return new FormapagoCollection($formapagos);
    }

    public function store(FormapagoStoreRequest $request): FormapagoResource
    {
        $this->authorize('create', Formapago::class);

        $validated = $request->validated();

        $formapago = Formapago::create($validated);

        return new FormapagoResource($formapago);
    }

    public function show(
        Request $request,
        Formapago $formapago
    ): FormapagoResource {
        $this->authorize('view', $formapago);

        return new FormapagoResource($formapago);
    }

    public function update(
        FormapagoUpdateRequest $request,
        Formapago $formapago
    ): FormapagoResource {
        $this->authorize('update', $formapago);

        $validated = $request->validated();

        $formapago->update($validated);

        return new FormapagoResource($formapago);
    }

    public function destroy(Request $request, Formapago $formapago): Response
    {
        $this->authorize('delete', $formapago);

        $formapago->delete();

        return response()->noContent();
    }
}
