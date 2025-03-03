<?php

namespace App\Http\Controllers\Api;

use App\Models\ApuestaPolla;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApuestaPollaResource;
use App\Http\Resources\ApuestaPollaCollection;
use App\Http\Requests\ApuestaPollaStoreRequest;
use App\Http\Requests\ApuestaPollaUpdateRequest;

class ApuestaPollaController extends Controller
{
    public function index(Request $request): ApuestaPollaCollection
    {
        $this->authorize('view-any', ApuestaPolla::class);

        $search = $request->get('search', '');

        $apuestaPollas = ApuestaPolla::search($search)
            ->latest()
            ->paginate();

        return new ApuestaPollaCollection($apuestaPollas);
    }

    public function store(
        ApuestaPollaStoreRequest $request
    ): ApuestaPollaResource {
        $this->authorize('create', ApuestaPolla::class);

        $validated = $request->validated();

        $apuestaPolla = ApuestaPolla::create($validated);

        return new ApuestaPollaResource($apuestaPolla);
    }

    public function show(
        Request $request,
        ApuestaPolla $apuestaPolla
    ): ApuestaPollaResource {
        $this->authorize('view', $apuestaPolla);

        return new ApuestaPollaResource($apuestaPolla);
    }

    public function update(
        ApuestaPollaUpdateRequest $request,
        ApuestaPolla $apuestaPolla
    ): ApuestaPollaResource {
        $this->authorize('update', $apuestaPolla);

        $validated = $request->validated();

        $apuestaPolla->update($validated);

        return new ApuestaPollaResource($apuestaPolla);
    }

    public function destroy(
        Request $request,
        ApuestaPolla $apuestaPolla
    ): Response {
        $this->authorize('delete', $apuestaPolla);

        $apuestaPolla->delete();

        return response()->noContent();
    }
}
