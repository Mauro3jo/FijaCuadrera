<?php

namespace App\Http\Controllers\Api;

use App\Models\Caballo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApuestaPollaUserResource;
use App\Http\Resources\ApuestaPollaUserCollection;

class CaballoApuestaPollaUsersController extends Controller
{
    public function index(
        Request $request,
        Caballo $caballo
    ): ApuestaPollaUserCollection {
        $this->authorize('view', $caballo);

        $search = $request->get('search', '');

        $apuestaPollaUsers = $caballo
            ->apuestaPollaUsers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ApuestaPollaUserCollection($apuestaPollaUsers);
    }

    public function store(
        Request $request,
        Caballo $caballo
    ): ApuestaPollaUserResource {
        $this->authorize('create', ApuestaPollaUser::class);

        $validated = $request->validate([
            'apuesta_polla_id' => ['required', 'exists:apuesta_pollas,id'],
            'user_id' => ['required', 'exists:users,id'],
            'Resultadoapuesta' => ['required', 'max:255', 'string'],
        ]);

        $apuestaPollaUser = $caballo->apuestaPollaUsers()->create($validated);

        return new ApuestaPollaUserResource($apuestaPollaUser);
    }
}
