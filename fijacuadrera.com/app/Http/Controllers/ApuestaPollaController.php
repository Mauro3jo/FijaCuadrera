<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\View\View;
use App\Models\ApuestaPolla;
use App\Models\ApuestaPollaUser;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ApuestaPollaStoreRequest;
use App\Http\Requests\ApuestaPollaUpdateRequest;

class ApuestaPollaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ApuestaPolla::class);

        $search = $request->get('search', '');

        $apuestaPollas = ApuestaPolla::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.apuesta_pollas.index',
            compact('apuestaPollas', 'search')
        );
    }
  
  public function mostrarApuestasPolla($carrera_id)
{
   // Buscar la carrera con el id dado y cargar los caballos
   $carrera = Carrera::with('caballos')->find($carrera_id);

   // Obtener un array con los nombres y los ids de los caballos
   $caballos = $carrera->caballos->pluck('nombre', 'id');
  
   // Obtener las apuestas pollas que están inactivas y cargar los datos relacionados
   $apuestas_pollas = ApuestaPolla::/*where('Estado', 0)->*/where('carrera_id', $carrera_id)->whereHas('apuestaPollaUsers')->with('apuestaPollaUsers')->get();

   // Retornar la vista con la carrera, los caballos y las apuestas
   return view('Polla', ['carrera' => $carrera, 'caballos' => $caballos, 'apuestas_pollas' => $apuestas_pollas]); 
}
public function entrar(Request $request)
{ 
    try {
        $user = auth()->user();

        $monto = intval($request->monto);
        $apuesta_polla_id = intval($request->apuesta_polla_id);
        $caballo_id = intval($request->caballoId);

        $apuestaPollaUser = new ApuestaPollaUser([
            'apuesta_polla_id' => $apuesta_polla_id,
            'user_id' => $user->id,
            'caballo_id' => $caballo_id,
            'Resultadoapuesta' => "Pendiente",
        ]);

        $apuestaPollaUser->save();

        $user->saldo -= $monto;
        $user->save();

        // Verificar si todos los caballos de la apuesta_polla tienen una apuesta en ApuestaPollaUser
        $apuestaPolla = ApuestaPolla::find($apuesta_polla_id);

        $caballosCompletosCount = 0;
        for ($i = 1; $i <= 5; $i++) {
            // Verificar si el caballo tiene un valor distinto de 0 y si ha recibido apuestas en ApuestaPollaUser
            if ($apuestaPolla->{'Caballo' . $i} !== null && $apuestaPolla->{'Caballo' . $i} !== 0) {
                $apuestasParaCaballo = ApuestaPollaUser::where('apuesta_polla_id', $apuesta_polla_id)
                    ->where('caballo_id', $apuestaPolla->{'Caballo' . $i})
                    ->exists();

                if ($apuestasParaCaballo) {
                    $caballosCompletosCount++;
                }
            }
        }

        // Considerar completo si hay al menos 3 caballos con un valor diferente de 0 y con apuestas en ApuestaPollaUser
        $todosCaballosCompletos = $caballosCompletosCount >= 3;

        if ($todosCaballosCompletos) {
            // Cambiar el Resultadoapuesta a "Completada" para todos los registros de ApuestaPollaUser asociados a esta apuesta
            ApuestaPollaUser::where('apuesta_polla_id', $apuesta_polla_id)
                ->update(['Resultadoapuesta' => 'Pendiente']);
        
            // Actualizar el estado de la ApuestaPolla
            $apuestaPolla->update(['Estado' => 1]); // 1 podría representar "Completada", ajusta según tus necesidades
        }

        return back()->with('success', 'Apuesta realizada con éxito');
    } catch (\Exception $e) {
        return back()->with('error', 'Error al realizar la apuesta: ' . $e->getMessage());
    }
}








    public function guardar(Request $request, $carrera_id)
    {
        
      // Get the IDs of the selected horses
$check = $request->input('check');

// Get all the amounts
$montos = $request->input('montos');

// Get all the horse IDs
$caballos = $request->input('caballos');

// Initialize an array to store the amounts of the selected horses


// Go through all the selected horses
foreach ($check as $selectedHorse) {
    // Find the index of the selected horse in the array of all horses
    $index = array_search($selectedHorse, $caballos);

    // If the index exists in the array of amounts, add the amount to the array of selected amounts
    if (isset($montos[$index])) {
        $monto = $montos[$index];
    }
}
//dd($montos);
// Now, $selectedMontos contains the amounts for all selected horses

      $user = auth()->user();
       
      if ($user->saldo >= $monto) {
        $apuesta = ApuestaPolla::where('carrera_id', $carrera_id)
            ->where(function ($query) use ($caballos, $montos) {
                for ($i = 0; $i < count($caballos); $i++) {
                    if (isset($caballos[$i])) {
                        $query->where(function ($query) use ($caballos, $montos, $i) {
                            $query->where('Caballo' . ($i + 1), $caballos[$i])
                                ->where('Monto' . ($i + 1), $montos[$i]);
                        });
                    }
                }
            })
            ->first();
    
        if ($apuesta) {
            $ocupado = ApuestaPollaUser::where('apuesta_polla_id', $apuesta->id)
                ->where('caballo_id', $check)
                ->exists();
    
            if ($ocupado) {
                $apuesta = ApuestaPolla::create([
                    'carrera_id' => $carrera_id,
                    'Ganancia' => 0,
                    'Caballo1' => $caballos[0] ?? 0,
                    'Monto1' => $montos[0] ?? 0,
                    'Caballo2' => $caballos[1] ?? 0,
                    'Monto2' => $montos[1] ?? 0,
                    'Caballo3' => $caballos[2] ?? 0,
                    'Monto3' => $montos[2] ?? 0,
                    'Caballo4' => $caballos[3] ?? 0,
                    'Monto4' => $montos[3] ?? 0,
                    'Caballo5' => $caballos[4] ?? 0,
                    'Monto5' => $montos[4] ?? 0,
                    'Estado' => 0,
                ]);
            }
        } else {
            $apuesta = ApuestaPolla::create([
                'carrera_id' => $carrera_id,
                'Ganancia' => 0,
                'Caballo1' => $caballos[0] ?? 0,
                'Monto1' => $montos[0] ?? 0,
                'Caballo2' => $caballos[1] ?? 0,
                'Monto2' => $montos[1] ?? 0,
                'Caballo3' => $caballos[2] ?? 0,
                'Monto3' => $montos[2] ?? 0,
                'Caballo4' => $caballos[3] ?? 0,
                'Monto4' => $montos[3] ?? 0,
                'Caballo5' => $caballos[4] ?? 0,
                'Monto5' => $montos[4] ?? 0,
                'Estado' => 0,
            ]);
        }
    
    
            foreach($check as $ch) {
                
                ApuestaPollaUser::create([
                    'apuesta_polla_id' => $apuesta->id,
                    'user_id' => $user->id,
                    'caballo_id' => $ch,
                    'Resultadoapuesta' => 'Pendiente',
                ]);
            }
            $allHorsesBetted = true;
            for ($i = 0; $i < count($caballos); $i++) {
                if ($caballos[$i] != 0) {
                    $betExists = ApuestaPollaUser::where('apuesta_polla_id', $apuesta->id)
                        ->where('caballo_id', $caballos[$i])
                        ->exists();
                    if (!$betExists) {
                        $allHorsesBetted = false;
                        break;
                    }
                }
            }
            
           
            if ($allHorsesBetted) {
                $apuesta->Estado = 1;
                $apuesta->save();
            
                ApuestaPollaUser::where('apuesta_polla_id', $apuesta->id)
                    ->update(['Resultadoapuesta' => 'Pendiente']);
            }
                 $user->saldo -= $monto;
            $user->save();

            return redirect()->back()->with('success', 'Su apuesta ha sido registrada');
        } else {
         
            return redirect()->back()->with('error', 'No tiene saldo suficiente para hacer la apuesta');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ApuestaPolla::class);

        $carreras = Carrera::pluck('nombre', 'id');

        return view('app.apuesta_pollas.create', compact('carreras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApuestaPollaStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', ApuestaPolla::class);

        $validated = $request->validated();

        $apuestaPolla = ApuestaPolla::create($validated);

        return redirect()
            ->route('apuesta-pollas.edit', $apuestaPolla)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ApuestaPolla $apuestaPolla): View
    {
        $this->authorize('view', $apuestaPolla);

        return view('app.apuesta_pollas.show', compact('apuestaPolla'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ApuestaPolla $apuestaPolla): View
    {
        $this->authorize('update', $apuestaPolla);

        $carreras = Carrera::pluck('nombre', 'id');

        return view(
            'app.apuesta_pollas.edit',
            compact('apuestaPolla', 'carreras')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ApuestaPollaUpdateRequest $request,
        ApuestaPolla $apuestaPolla
    ): RedirectResponse {
        $this->authorize('update', $apuestaPolla);

        $validated = $request->validated();

        $apuestaPolla->update($validated);

        return redirect()
            ->route('apuesta-pollas.edit', $apuestaPolla)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        ApuestaPolla $apuestaPolla
    ): RedirectResponse {
        $this->authorize('delete', $apuestaPolla);

        $apuestaPolla->delete();

        return redirect()
            ->route('apuesta-pollas.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
