<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Apuestamanomano;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApuestamanomanoUserResource;
use App\Http\Resources\ApuestamanomanoUserCollection;

class ApuestamanomanoApuestamanomanoUsersController extends Controller
{
    public function index(
        Request $request,
        Apuestamanomano $apuestamanomano
    ): ApuestamanomanoUserCollection {
        $this->authorize('view', $apuestamanomano);

        $search = $request->get('search', '');

        $apuestamanomanoUsers = $apuestamanomano
            ->apuestamanomanoUsers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ApuestamanomanoUserCollection($apuestamanomanoUsers);
    }

    public function store(
        Request $request,
        Apuestamanomano $apuestamanomano
    ): ApuestamanomanoUserResource {
        $this->authorize('create', ApuestamanomanoUser::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'caballo_id' => ['required', 'exists:caballos,id'],
            'resultadoapuesta' => ['required', 'max:255', 'string'],
        ]);

        $apuestamanomanoUser = $apuestamanomano
            ->apuestamanomanoUsers()
            ->create($validated);

        return new ApuestamanomanoUserResource($apuestamanomanoUser);
    }
}
