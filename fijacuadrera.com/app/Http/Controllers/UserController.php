<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ApuestamanomanoUser;
use App\Models\ApuestaPollaUser;
use App\Models\LlaveUser;
use App\Models\Llave;
use App\Models\Caballo;

use App\Models\ApuestaPolla;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
       // $this->authorize('view-any', User::class);

        $search = $request->get('search', '');

        $users = User::search($search)
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('app.users.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
             //   $this->authorize('create', User::class);

        return view('app.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
          //      $this->authorize('create', User::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user): View
    {
            //    $this->authorize('view', $user);

        return view('app.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user): View
    {
            //    $this->authorize('update', $user);

        return view('app.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UserUpdateRequest $request,
        User $user
    ): RedirectResponse {
              //  $this->authorize('update', $user);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.index', $user)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
              //  $this->authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->withSuccess(__('crud.common.removed'));
    }
 public function showHistorialJugadas()
    {
        $user_id = auth()->id();
        $apuestasManoAMano = ApuestamanomanoUser::where('user_id', $user_id)->get();
    
      
$llaves = LlaveUser::where('user_id', $user_id)->with('llave')->get();

    
        
$apuestasManoAMano = ApuestamanomanoUser::where('user_id', $user_id)->get();


foreach ($apuestasManoAMano as $apuesta) {
    $apuestaManoAMano = $apuesta->apuestamanomano;
    
    
    $apuestasRelacionadas = $apuestaManoAMano->apuestamanomanoUsers;

    if ($apuesta->id === $apuestasRelacionadas->first()->id) {
        $apuestaManoAMano->Tipo = $apuestaManoAMano->Tipo;
    } else {
        if( $apuestaManoAMano->Tipo=="pago"){
                    $apuestaManoAMano->Tipo = $apuestaManoAMano->Tipo === 'pago';

        }
        else{
                    $apuestaManoAMano->Tipo = $apuestaManoAMano->Tipo === 'doy' ? 'recibo' : 'doy';

        }
    }

    if ($apuesta->id !== $apuestasRelacionadas->first()->id) {
        $apuestaManoAMano->Caballo1 = $apuestaManoAMano->Caballo2;
    }
}

$apuestasPolla = ApuestaPollaUser::where('user_id', $user_id)->get();

// Crear un array para almacenar los resultados consolidados
$resultadosApuestasPolla = [];

foreach ($apuestasPolla as $apuestaPollaUser) {
    $apuestaPolla = $apuestaPollaUser->apuestaPolla;
    $id = $apuestaPolla->id;

    // Inicializar el array de detalles si aún no se ha creado para este id
    if (!isset($resultadosApuestasPolla[$id])) {
        $resultadosApuestasPolla[$id] = [
            'apuesta_polla_id' => $id,
            'caballos' => [],
            'montos' => [],
            'estado' => [],
            'CaballoJugado' => [],
            'resultado_apuesta' => [],
            'a_depositar' => []
        ];
    }

    for ($i = 1; $i <= 5; $i++) {
        $caballoId = $apuestaPolla->{"Caballo$i"};
        if ($caballoId != 0) {
            $caballo = Caballo::find($caballoId);
            $nombreCaballo = $caballo ? $caballo->nombre : 'Nombre no disponible';
            $monto = $apuestaPolla->{"Monto$i"};
            $estado = $apuestaPolla->{"Estado"} == true ? 'Jugada' : 'Pendiente';

            // Agregar o actualizar los detalles del caballo y el monto al array consolidado
            $resultadosApuestasPolla[$id]['caballos'][$caballoId] = $nombreCaballo;
            $resultadosApuestasPolla[$id]['montos'][$caballoId] = $monto;
            $resultadosApuestasPolla[$id]['estado'][$caballoId] = $estado;

            // Verificar si la apuesta pertenece al usuario autenticado y si el caballo_id coincide
            if ($apuestaPollaUser->user_id == $user_id && $apuestaPollaUser->caballo_id == $caballoId) {
                // Agregar o actualizar el caballo al array 'CaballoJugado'
                $resultadosApuestasPolla[$id]['CaballoJugado'][$caballoId] = $nombreCaballo;
                $resultadosApuestasPolla[$id]['resultado_apuesta'][$caballoId] = $apuestaPollaUser->Resultadoapuesta;
                $resultadosApuestasPolla[$id]['a_depositar'][$caballoId] = $monto;
            }
        }
    }
}

// Ahora $resultadosApuestasPolla contiene los detalles de apuestas consolidados por apuesta_polla_id


      
    


return view('HistorialJugadas', [
    'apuestasManoAMano' => $apuestasManoAMano,
    'apuestasPolla' => $resultadosApuestasPolla, // Pasar el array de resultados
    'llaves' => $llaves,
]);
}



}
