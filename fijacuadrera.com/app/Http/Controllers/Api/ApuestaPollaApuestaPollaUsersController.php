<?php

namespace App\Http\Controllers\Api;

use App\Models\ApuestaPolla;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApuestaPollaUserResource;
use App\Http\Resources\ApuestaPollaUserCollection;

class ApuestaPollaApuestaPollaUsersController extends Controller
{
    public function index(
        Request $request,
        ApuestaPolla $apuestaPolla
    ): ApuestaPollaUserCollection {
        $this->authorize('view', $apuestaPolla);

        $search = $request->get('search', '');

        $apuestaPollaUsers = $apuestaPolla
            ->apuestaPollaUsers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ApuestaPollaUserCollection($apuestaPollaUsers);
    }

    public function store(
        Request $request,
        ApuestaPolla $apuestaPolla
    ): ApuestaPollaUserResource {
        $this->authorize('create', ApuestaPollaUser::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'caballo_id' => ['required', 'exists:caballos,id'],
            'Resultadoapuesta' => ['required', 'max:255', 'string'],
        ]);

        $apuestaPollaUser = $apuestaPolla
            ->apuestaPollaUsers()
            ->create($validated);

        return new ApuestaPollaUserResource($apuestaPollaUser);
    }
}
