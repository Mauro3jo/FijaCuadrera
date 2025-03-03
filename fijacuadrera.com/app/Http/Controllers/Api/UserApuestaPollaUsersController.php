<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApuestaPollaUserResource;
use App\Http\Resources\ApuestaPollaUserCollection;

class UserApuestaPollaUsersController extends Controller
{
    public function index(
        Request $request,
        User $user
    ): ApuestaPollaUserCollection {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $apuestaPollaUsers = $user
            ->apuestaPollaUsers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ApuestaPollaUserCollection($apuestaPollaUsers);
    }

    public function store(
        Request $request,
        User $user
    ): ApuestaPollaUserResource {
        $this->authorize('create', ApuestaPollaUser::class);

        $validated = $request->validate([
            'apuesta_polla_id' => ['required', 'exists:apuesta_pollas,id'],
            'caballo_id' => ['required', 'exists:caballos,id'],
            'Resultadoapuesta' => ['required', 'max:255', 'string'],
        ]);

        $apuestaPollaUser = $user->apuestaPollaUsers()->create($validated);

        return new ApuestaPollaUserResource($apuestaPollaUser);
    }
}
