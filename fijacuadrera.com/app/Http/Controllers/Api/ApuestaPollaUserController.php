<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ApuestaPollaUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApuestaPollaUserResource;
use App\Http\Resources\ApuestaPollaUserCollection;
use App\Http\Requests\ApuestaPollaUserStoreRequest;
use App\Http\Requests\ApuestaPollaUserUpdateRequest;

class ApuestaPollaUserController extends Controller
{
    public function index(Request $request): ApuestaPollaUserCollection
    {
        $this->authorize('view-any', ApuestaPollaUser::class);

        $search = $request->get('search', '');

        $apuestaPollaUsers = ApuestaPollaUser::search($search)
            ->latest()
            ->paginate();

        return new ApuestaPollaUserCollection($apuestaPollaUsers);
    }

    public function store(
        ApuestaPollaUserStoreRequest $request
    ): ApuestaPollaUserResource {
        $this->authorize('create', ApuestaPollaUser::class);

        $validated = $request->validated();

        $apuestaPollaUser = ApuestaPollaUser::create($validated);

        return new ApuestaPollaUserResource($apuestaPollaUser);
    }

    public function show(
        Request $request,
        ApuestaPollaUser $apuestaPollaUser
    ): ApuestaPollaUserResource {
        $this->authorize('view', $apuestaPollaUser);

        return new ApuestaPollaUserResource($apuestaPollaUser);
    }

    public function update(
        ApuestaPollaUserUpdateRequest $request,
        ApuestaPollaUser $apuestaPollaUser
    ): ApuestaPollaUserResource {
        $this->authorize('update', $apuestaPollaUser);

        $validated = $request->validated();

        $apuestaPollaUser->update($validated);

        return new ApuestaPollaUserResource($apuestaPollaUser);
    }

    public function destroy(
        Request $request,
        ApuestaPollaUser $apuestaPollaUser
    ): Response {
        $this->authorize('delete', $apuestaPollaUser);

        $apuestaPollaUser->delete();

        return response()->noContent();
    }
}
