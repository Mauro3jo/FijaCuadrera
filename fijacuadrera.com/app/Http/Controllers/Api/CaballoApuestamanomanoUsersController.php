<?php

namespace App\Http\Controllers\Api;

use App\Models\Caballo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApuestamanomanoUserResource;
use App\Http\Resources\ApuestamanomanoUserCollection;

class CaballoApuestamanomanoUsersController extends Controller
{
    public function index(
        Request $request,
        Caballo $caballo
    ): ApuestamanomanoUserCollection {
        $this->authorize('view', $caballo);

        $search = $request->get('search', '');

        $apuestamanomanoUsers = $caballo
            ->apuestamanomanoUsers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ApuestamanomanoUserCollection($apuestamanomanoUsers);
    }

    public function store(
        Request $request,
        Caballo $caballo
    ): ApuestamanomanoUserResource {
        $this->authorize('create', ApuestamanomanoUser::class);

        $validated = $request->validate([
            'apuestamanomano_id' => ['required', 'exists:apuestamanomanos,id'],
            'user_id' => ['required', 'exists:users,id'],
            'resultadoapuesta' => ['required', 'max:255', 'string'],
        ]);

        $apuestamanomanoUser = $caballo
            ->apuestamanomanoUsers()
            ->create($validated);

        return new ApuestamanomanoUserResource($apuestamanomanoUser);
    }
}
