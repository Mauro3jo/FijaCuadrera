<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApuestamanomanoUserResource;
use App\Http\Resources\ApuestamanomanoUserCollection;

class UserApuestamanomanoUsersController extends Controller
{
    public function index(
        Request $request,
        User $user
    ): ApuestamanomanoUserCollection {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $apuestamanomanoUsers = $user
            ->apuestamanomanoUsers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ApuestamanomanoUserCollection($apuestamanomanoUsers);
    }

    public function store(
        Request $request,
        User $user
    ): ApuestamanomanoUserResource {
        $this->authorize('create', ApuestamanomanoUser::class);

        $validated = $request->validate([
            'apuestamanomano_id' => ['required', 'exists:apuestamanomanos,id'],
            'caballo_id' => ['required', 'exists:caballos,id'],
            'resultadoapuesta' => ['required', 'max:255', 'string'],
        ]);

        $apuestamanomanoUser = $user
            ->apuestamanomanoUsers()
            ->create($validated);

        return new ApuestamanomanoUserResource($apuestamanomanoUser);
    }
}
