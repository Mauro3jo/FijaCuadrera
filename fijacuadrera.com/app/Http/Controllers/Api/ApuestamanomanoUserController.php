<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ApuestamanomanoUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApuestamanomanoUserResource;
use App\Http\Resources\ApuestamanomanoUserCollection;
use App\Http\Requests\ApuestamanomanoUserStoreRequest;
use App\Http\Requests\ApuestamanomanoUserUpdateRequest;

class ApuestamanomanoUserController extends Controller
{
    public function index(Request $request): ApuestamanomanoUserCollection
    {
        $this->authorize('view-any', ApuestamanomanoUser::class);

        $search = $request->get('search', '');

        $apuestamanomanoUsers = ApuestamanomanoUser::search($search)
            ->latest()
            ->paginate();

        return new ApuestamanomanoUserCollection($apuestamanomanoUsers);
    }

    public function store(
        ApuestamanomanoUserStoreRequest $request
    ): ApuestamanomanoUserResource {
        $this->authorize('create', ApuestamanomanoUser::class);

        $validated = $request->validated();

        $apuestamanomanoUser = ApuestamanomanoUser::create($validated);

        return new ApuestamanomanoUserResource($apuestamanomanoUser);
    }

    public function show(
        Request $request,
        ApuestamanomanoUser $apuestamanomanoUser
    ): ApuestamanomanoUserResource {
        $this->authorize('view', $apuestamanomanoUser);

        return new ApuestamanomanoUserResource($apuestamanomanoUser);
    }

    public function update(
        ApuestamanomanoUserUpdateRequest $request,
        ApuestamanomanoUser $apuestamanomanoUser
    ): ApuestamanomanoUserResource {
        $this->authorize('update', $apuestamanomanoUser);

        $validated = $request->validated();

        $apuestamanomanoUser->update($validated);

        return new ApuestamanomanoUserResource($apuestamanomanoUser);
    }

    public function destroy(
        Request $request,
        ApuestamanomanoUser $apuestamanomanoUser
    ): Response {
        $this->authorize('delete', $apuestamanomanoUser);

        $apuestamanomanoUser->delete();

        return response()->noContent();
    }
}
