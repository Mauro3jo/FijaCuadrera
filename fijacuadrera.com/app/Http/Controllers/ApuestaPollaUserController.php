<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Caballo;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ApuestaPolla;
use App\Models\ApuestaPollaUser;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ApuestaPollaUserStoreRequest;
use App\Http\Requests\ApuestaPollaUserUpdateRequest;

class ApuestaPollaUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ApuestaPollaUser::class);

        $search = $request->get('search', '');

        $apuestaPollaUsers = ApuestaPollaUser::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.apuesta_polla_users.index',
            compact('apuestaPollaUsers', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ApuestaPollaUser::class);

        $apuestaPollas = ApuestaPolla::pluck('Caballo1', 'id');
        $users = User::pluck('name', 'id');
        $caballos = Caballo::pluck('nombre', 'id');

        return view(
            'app.apuesta_polla_users.create',
            compact('apuestaPollas', 'users', 'caballos')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        ApuestaPollaUserStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', ApuestaPollaUser::class);

        $validated = $request->validated();

        $apuestaPollaUser = ApuestaPollaUser::create($validated);

        return redirect()
            ->route('apuesta-polla-users.edit', $apuestaPollaUser)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        ApuestaPollaUser $apuestaPollaUser
    ): View {
        $this->authorize('view', $apuestaPollaUser);

        return view(
            'app.apuesta_polla_users.show',
            compact('apuestaPollaUser')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        ApuestaPollaUser $apuestaPollaUser
    ): View {
        $this->authorize('update', $apuestaPollaUser);

        $apuestaPollas = ApuestaPolla::pluck('Caballo1', 'id');
        $users = User::pluck('name', 'id');
        $caballos = Caballo::pluck('nombre', 'id');

        return view(
            'app.apuesta_polla_users.edit',
            compact('apuestaPollaUser', 'apuestaPollas', 'users', 'caballos')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ApuestaPollaUserUpdateRequest $request,
        ApuestaPollaUser $apuestaPollaUser
    ): RedirectResponse {
        $this->authorize('update', $apuestaPollaUser);

        $validated = $request->validated();

        $apuestaPollaUser->update($validated);

        return redirect()
            ->route('apuesta-polla-users.edit', $apuestaPollaUser)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        ApuestaPollaUser $apuestaPollaUser
    ): RedirectResponse {
        $this->authorize('delete', $apuestaPollaUser);

        $apuestaPollaUser->delete();

        return redirect()
            ->route('apuesta-polla-users.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
