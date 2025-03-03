<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Caballo;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Apuestamanomano;
use App\Models\ApuestamanomanoUser;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ApuestamanomanoUserStoreRequest;
use App\Http\Requests\ApuestamanomanoUserUpdateRequest;

class ApuestamanomanoUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ApuestamanomanoUser::class);

        $search = $request->get('search', '');

        $apuestamanomanoUsers = ApuestamanomanoUser::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.apuestamanomano_users.index',
            compact('apuestamanomanoUsers', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ApuestamanomanoUser::class);

        $apuestamanomanos = Apuestamanomano::pluck('Caballo1', 'id');
        $users = User::pluck('name', 'id');
        $caballos = Caballo::pluck('nombre', 'id');

        return view(
            'app.apuestamanomano_users.create',
            compact('apuestamanomanos', 'users', 'caballos')
        );
    }
    public function createApuesta(Request $request)
    {
        // Validar los datos del request
        $request->validate([
            'carrera_id' => 'required|integer|exists:carreras,id',
            'tipo' => 'required|in:pago,doy,recibo',
            'monto1' => 'required|numeric|min:0',
            'monto2' => 'required|numeric|min:0',
            'caballo1' => 'required|string|exists:caballos,nombre',
            'caballo2' => 'required|string|exists:caballos,nombre',
        ]);

        // Crear una instancia de Apuestamanomano
        $apuesta = new Apuestamanomano();

        // Asignar los valores del request
        $apuesta->carrera_id = $request->carrera_id;
        $apuesta->tipo = $request->tipo;
        $apuesta->monto1 = $request->monto1;
        $apuesta->monto2 = $request->monto2;
        $apuesta->caballo1 = $request->caballo1; // Asignar el nombre del caballo 1
        $apuesta->caballo2 = $request->caballo2; // Asignar el nombre del caballo 2

        // Calcular la ganancia según el tipo de apuesta
        if ($apuesta->tipo == 'pago') {
            // La ganancia es la suma de los montos
            $apuesta->ganancia = $apuesta->monto1 + $apuesta->monto2;
        } elseif ($apuesta->tipo == 'doy') {
            // La ganancia es la diferencia entre los montos
            $apuesta->ganancia = $apuesta->monto1 - $apuesta->monto2;
        } else {
            // La ganancia es la diferencia entre los montos
            $apuesta->ganancia = $apuesta->monto2 - $apuesta->monto1;
        }

        // Asignar el estado como 0 (pendiente)
        $apuesta->estado = 0;

        // Guardar la apuesta en la base de datos
        $apuesta->save();

        // Crear una instancia de ApuestamanomanoUser
        $apuestamanomanoUser = new ApuestamanomanoUser();

        // Asignar los valores del request y de la apuesta
        $apuestamanomanoUser->apuestamanomano_id = $apuesta->id;
        $apuestamanomanoUser->user_id = auth()->user()->id; // Obtener el id del usuario autenticado
        if ($apuesta->tipo == 'recibo') {
            // Si el tipo es recibo, se asigna el caballo 2
            $apuestamanomanoUser->caballo_id = Caballo::where('nombre', '=', $request->caballo2)->first()->id; // Obtener el id del caballo por su nombre
        } else {
            // Si no, se asigna el caballo 1
            $apuestamanomanoUser->caballo_id = Caballo::where('nombre', '=', $request->caballo1)->first()->id; // Obtener el id del caballo por su nombre
        }

        // No asignar nada al resultado apuesta
        $apuestamanomanoUser->resultadoapuesta = null;

        // Guardar la apuestamanomanoUser en la base de datos
        $apuestamanomanoUser->save();

        // Retornar una respuesta al usuario
        return response()->json([
            'message' => 'Apuesta creada con éxito',
            'data' => [
                'apuesta' => $apuesta,
                'apuestamanomanoUser' => $apuestamanomanoUser,
            ],
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(
        ApuestamanomanoUserStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', ApuestamanomanoUser::class);

        $validated = $request->validated();

        $apuestamanomanoUser = ApuestamanomanoUser::create($validated);

        return redirect()
            ->route('apuestamanomano-users.edit', $apuestamanomanoUser)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        ApuestamanomanoUser $apuestamanomanoUser
    ): View {
        $this->authorize('view', $apuestamanomanoUser);

        return view(
            'app.apuestamanomano_users.show',
            compact('apuestamanomanoUser')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        ApuestamanomanoUser $apuestamanomanoUser
    ): View {
        $this->authorize('update', $apuestamanomanoUser);

        $apuestamanomanos = Apuestamanomano::pluck('Caballo1', 'id');
        $users = User::pluck('name', 'id');
        $caballos = Caballo::pluck('nombre', 'id');

        return view(
            'app.apuestamanomano_users.edit',
            compact(
                'apuestamanomanoUser',
                'apuestamanomanos',
                'users',
                'caballos'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ApuestamanomanoUserUpdateRequest $request,
        ApuestamanomanoUser $apuestamanomanoUser
    ): RedirectResponse {
        $this->authorize('update', $apuestamanomanoUser);

        $validated = $request->validated();

        $apuestamanomanoUser->update($validated);

        return redirect()
            ->route('apuestamanomano-users.edit', $apuestamanomanoUser)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        ApuestamanomanoUser $apuestamanomanoUser
    ): RedirectResponse {
        $this->authorize('delete', $apuestamanomanoUser);

        $apuestamanomanoUser->delete();

        return redirect()
            ->route('apuestamanomano-users.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
