<?php

namespace App\Http\Controllers;

use App\Models\Hipico;
use Illuminate\Support\Facades\Storage;

use App\Models\Carrera;
use App\Models\HistorialUser;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CarreraStoreRequest;
use App\Http\Requests\CarreraUpdateRequest;
use App\Models\Caballo;
use App\Models\Apuestamanomano;
use App\Models\User;
use App\Models\ApuestaPolla;
use App\Models\ApuestaPollaUser;
use DateTimeZone;  // Importa DateTimeZone desde el espacio de nombres global

use App\Models\ApuestamanomanoUser;

use Carbon\Carbon;


class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Carrera::class);

        $search = $request->get('search', '');

        $carreras = Carrera::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.carreras.index', compact('carreras', 'search'));
    }
  
    
   // Agregar esta función al controlador CarreraController
// En tu controlador
  public function proximasCarreras($id)
    {
        // Obtener la fecha actual
        $hoy = date('Y-m-d');

        // Obtener las carreras que cumplan con las condiciones
        $carreras = Carrera::with('hipico', 'caballos')
            ->where('fecha', '>', $hoy) // Fecha posterior a hoy
            ->where('estado', 0) // Estado igual a 0
            ->where('hipico_id', $id) // Hipódromo igual al ID proporcionado
            ->orderBy('fecha', 'asc') // Ordenar por fecha ascendente
            ->get() // Obtener la colección de carreras
            ->groupBy(function ($carrera) {
                // Establecer el idioma al español
                Carbon::setLocale('es');
                // Agrupar las carreras por fecha usando el formato que prefieras
                return $carrera->fecha->isoFormat('dddd D [de] MMMM [de] YYYY');
            });

        // Retornar la vista 'carreras' con las carreras
        return view('Carreras', ['carreras' => $carreras]);
    } 
    public function actualizarEstadoCarreras()
    {
        // Obtener la fecha y hora actual en Argentina
        $ahora = Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'));

        // Actualizar las carreras cuya fecha y hora ya han pasado
        Carrera::where('fecha', '<', $ahora)
            ->where('estado', 0)
            ->update(['estado' => 1]);
    }


   

   
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Carrera::class);

        $hipicos = Hipico::pluck('nombre', 'id');
        $caballos = Caballo::pluck('nombre', 'id');

        return view('app.carreras.create', compact('hipicos', 'caballos')); // Pasar las variables a la vista
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar y crear la carrera
        $carrera = Carrera::create($request->validate([
            'nombre' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hipico_id' => 'required|exists:hipicos,id',
        ]));
    
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            // Cambiar esta línea
            $filePath = $image->move('imagenes', $image->getClientOriginalName()); // Mueve la imagen a public/imagenes con el nombre original
            $carrera->imagen = str_replace('public/', '', $filePath); // Guarda la ruta de la imagen en la base de datos (sin "public/")
            
            $carrera->save();
        }
        
        // Obtener los ids de los caballos seleccionados
        $caballos = $request->input('caballos');
    
        // Filtrar los ids que no estén vacíos
        $caballos = array_filter($caballos, function ($id) {
            return !empty($id);
        });
    
        // Relacionar los caballos con la carrera usando attach o sync
        $carrera->caballos()->attach($caballos);
    
        // Redireccionar a la vista de la carrera creada
        return redirect()->route('carreras.index', $carrera);
    }
    




    /**
     * Display the specified resource.
     */
    public function show(Request $request, Carrera $carrera): View
    {
        $this->authorize('view', $carrera);

        return view('app.carreras.show', compact('carrera'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Carrera $carrera): View
    {
        $this->authorize('update', $carrera);
    
        // Cargar los caballos y el resultado de la tabla pivot
        $caballos_carrera = $carrera->load('caballos.carreras');

    
        $hipicos = Hipico::pluck('nombre', 'id');
        $caballos = Caballo::pluck('nombre', 'id');
        return view('app.carreras.edit', compact('carrera', 'hipicos','caballos', 'caballos_carrera'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(CarreraUpdateRequest $request, Carrera $carrera): RedirectResponse
{
    $this->authorize('update', $carrera);

    $validated = $request->validated();
    // Si se subió una nueva imagen, almacenarla y guardar el nombre del archivo en la base de datos
    if ($request->hasFile('imagen')) {
        // Eliminar la imagen anterior si existe
        if ($carrera->imagen) {
            Storage::delete('public/' . $carrera->imagen);
        }

        // Almacenar la nueva imagen
        $imagePath = $request->file('imagen')->store('public/imagenes');
        $validated['imagen'] = str_replace('public/', '', $imagePath);
    } elseif ($carrera->imagen === null) {
        // Si la imagen es null y no se ha subido una nueva imagen, establecerla en null nuevamente
        $validated['imagen'] = null;
    }

    // Actualizar los datos de la carrera
    $carrera->update($validated);

    // Obtener los ids de los caballos seleccionados
    $caballos = $request->input('caballos');

    // Obtener los resultados de cada caballo
    $resultados = $request->input('resultados');

    // Crear un array asociativo con los ids de los caballos y los resultados
    $data = array_combine($caballos, $resultados);

    // Recorrer el array y actualizar el resultado de cada caballo usando updateExistingPivot
    foreach ($data as $caballo_id => $resultado) {
        $carrera->caballos()->updateExistingPivot($caballo_id, ['resultado' => $resultado]);
    }

    return redirect()
        ->route('carreras.index', $carrera)
        ->withSuccess(__('crud.common.saved'));
}

    /*
public function cerrar(Request $request, Carrera $carrera): RedirectResponse {
    $carrera->estado = 1;
    $carrera->save();
    // Obtener los resultados de los caballos de la carrera
    $resultados = $carrera->caballos()->wherePivot('carrera_id', $carrera->id)->pluck('resultado', 'id');
$numCaballos = $carrera->caballos()->count();
if ($numCaballos == 2) {
    // Iterar sobre los resultados de los caballos
    foreach ($resultados as $caballoId => $resultado) {
        // Buscar las apuestas relacionadas con este caballo
        $apuestas = ApuestamanomanoUser::whereHas('apuestamanomano', function ($query) use ($carrera) {
            $query->where('carrera_id', $carrera->id);
        })->where('caballo_id', $caballoId)->get();

        // Iterar sobre las apuestas para este caballo
        foreach ($apuestas as $apuesta) {
            // Verificar si hay exactamente dos registros relacionados en ApuestamanomanoUser
            $numApuestasRelacionadas = $apuesta->apuestamanomano->apuestamanomanoUsers()->count();

            // Si no hay exactamente dos registros relacionados, considerar la apuesta como cancelada
            if ($numApuestasRelacionadas == 1) {
                // Obtener el monto total de la apuesta
                $montoTotal = $apuesta->apuestamanomano->Monto1 + $apuesta->apuestamanomano->Monto2;

                // Devolver el saldo al usuario según el caballo por el que haya apostado
                if ($apuesta->caballo_id == $caballoId) {
                    // El usuario apostó por este caballo
                    $user = User::find($apuesta->user_id);
                    $user->saldo += $apuesta->apuestamanomano->Monto1; // Devolver solo el monto por el que jugó el usuario
                    $apuesta->resultadoapuesta = 'Cancelada';
                    $user->save();
                    $apuesta->save();
                } else {
                    // El usuario apostó por el otro caballo
                    $user = User::find($apuesta->user_id);
                    $user->saldo += $apuesta->apuestamanomano->Monto2; // Devolver el monto por el que jugó el usuario
                    $apuesta->resultadoapuesta = 'Cancelada';
                    $user->save();
                    $apuesta->save();
                }

                continue; // Pasar a la siguiente apuesta
            }

            // Procesar la apuesta normalmente
            // Obtener el usuario asociado a esta apuesta
            $user = User::find($apuesta->user_id);
            $userId = $apuesta->user_id; // o el ID que necesites

            // Establecer las fechas de INICIO y FIN
            $inicio = Carbon::now()->previous(Carbon::WEDNESDAY);
            $fin = Carbon::now()->next(Carbon::WEDNESDAY);
            
            // Buscar un historial existente que tenga FIN en el próximo miércoles
            $historialUser = HistorialUser::where('user_id', $userId)
                                          ->whereDate('FIN', $fin)
                                          ->first();
            
            if (!$historialUser) {
                // Si no existe, crear uno nuevo
                $historialUser = new HistorialUser([
                    'user_id' => $userId,
                    'INICIO' => $inicio->toDateString(),
                    'FIN' => $fin->toDateString(),
                    // Los demás campos se dejan sin datos (null)
                ]);
            
                // Guardar el nuevo historial en la base de datos
                $historialUser->save();
            }
            
            // Continuar con la lógica de procesamiento de la apuesta...
            // (Aquí va el resto de tu código de procesamiento de la apuesta)
            
            // No olvides guardar los cambios en el usuario y en la apuesta al final
            $user->save();
            $apuesta->save();
            // Obtener el monto de la apuesta directamente de la relación Apuestamanomano
            $montoTotal = $apuesta->apuestamanomano->Monto1 + $apuesta->apuestamanomano->Monto2;
            // Actualizar los campos según el resultado de la carrera
       // Modificar la apuesta normalmente
if ($apuesta->caballo_id == $caballoId) {
    // El usuario apostó por este caballo
    if ($resultado == 1) { // Si el resultado es positivo, el caballo es el ganador
        if ($apuesta->apuestamanomano->Tipo == "recibo") {
            $user->Gano += $apuesta->apuestamanomano->Monto1;
            $user->Comision += $apuesta->apuestamanomano->Monto1 * 0.05;
            $user->Jugo += $apuesta->apuestamanomano->Monto2;
            $apuesta->resultadoapuesta = 'Ganó';
        } else {
            $user->Gano += $apuesta->apuestamanomano->Monto2;
            $user->Comision += $apuesta->apuestamanomano->Monto2 * 0.05;
            $user->Jugo += $apuesta->apuestamanomano->Monto1;
            $apuesta->resultadoapuesta = 'Ganó';
        }
    } else if ($resultado == 0) { // Si el resultado es 0, el caballo es empate
        // Devolver el saldo al usuario según el caballo por el que haya apostado
        if ($apuesta->apuestamanomano->Tipo == "recibo") {
            $user->saldo += $apuesta->apuestamanomano->Monto1; // Devolver solo el monto por el que jugó el usuario
            $apuesta->resultadoapuesta = 'Empate';
        } else {
            $user->saldo += $apuesta->apuestamanomano->Monto2; // Devolver el monto por el que jugó el usuario
            $apuesta->resultadoapuesta = 'Empate';
        }
    } else {
        $user->Perdio += $apuesta->apuestamanomano->Monto1; // Sumar solo el monto por el que jugó el usuario
        $user->Jugo += $apuesta->apuestamanomano->Monto1; // Sumar el monto a Jugo
        $apuesta->resultadoapuesta = 'Perdió';
    }
} else {
    // El usuario apostó por el otro caballo
    if ($resultado == 2) { // Si el resultado es positivo, el caballo es perdedor
        $user->Perdio += $apuesta->apuestamanomano->Monto2; // Sumar solo el monto por el que jugó el usuario
        $user->Jugo += $apuesta->apuestamanomano->Monto2; // Sumar el monto a Jugo
        $apuesta->resultadoapuesta = 'Perdió';
    } else if ($resultado == 0) { // Si el resultado es 0, el caballo es empate
        // Devolver el saldo al usuario según el caballo por el que haya apostado
        if ($apuesta->apuestamanomano->Tipo == "recibo") {
            $user->saldo += $apuesta->apuestamanomano->Monto2; // Devolver el monto por el que jugó el usuario
            $apuesta->resultadoapuesta = 'Empate';
        } else {
            $user->saldo += $apuesta->apuestamanomano->Monto1; // Devolver el monto por el que jugó el usuario
            $apuesta->resultadoapuesta = 'Empate';
        }
    } else {
        $user->Gano += $apuesta->apuestamanomano->Monto1;
        $user->Comision += $montoTotal * 0.05;
        $apuesta->resultadoapuesta = 'Ganó';
        $user->Jugo += $apuesta->apuestamanomano->Monto2; // Sumar el monto a Jugo
    }
}

// Guardar los cambios en el usuario
$user->save();
// Guardar los cambios en la apuesta
$apuesta->save();

}}
    // Redireccionar a la página de índice de carreras con un mensaje de éxito
    return redirect()->route('carreras.index', $carrera)
                     ->with('success', 'La carrera se ha cerrado correctamente.');
} if ($numCaballos >= 3) {
    $apuestasPolla = $carrera->apuestaPollas()->withCount('apuestaPollaUsers')->get();
    $caballoGanadorId = $carrera->caballos()->wherePivot('resultado', 1)->value('id');

    foreach ($apuestasPolla as $apuesta) {
        if ($apuesta->apuesta_polla_users_count >= 3) {
            foreach ($apuesta->apuestaPollaUsers as $apuestaPollaUser) {
                $user = User::find($apuestaPollaUser->user_id);
                $montoApostado = 0;
                $gananciaTotal = 0;

                if ($apuestaPollaUser->caballo_id == $caballoGanadorId) {
                    $montos = [$apuesta->Monto1, $apuesta->Monto2, $apuesta->Monto3, $apuesta->Monto4, $apuesta->Monto5];
                    $caballos = [$apuesta->Caballo1, $apuesta->Caballo2, $apuesta->Caballo3, $apuesta->Caballo4, $apuesta->Caballo5];

                    foreach ($caballos as $index => $caballoId) {
                        if ($caballoId != 0 && $caballoId != $caballoGanadorId && $apuestaPollaUser->caballo_id != $caballoId) {
                            $hayApuestas = ApuestaPollaUser::where('caballo_id', $caballoId)->exists();
                            if ($hayApuestas) {
                                $gananciaTotal += $montos[$index];
                            }
                        }
                        if ($apuestaPollaUser->caballo_id == $caballoId) {
                            $montoApostado = $montos[$index];
                        }
                    }

                    $user->Gano += $gananciaTotal;
                    $user->Comision += $gananciaTotal * 0.05;
                    $user->Jugo += $montoApostado;
                    $apuestaPollaUser->Resultadoapuesta = 'Ganó';
                } else {
                    $montos = [$apuesta->Monto1, $apuesta->Monto2, $apuesta->Monto3, $apuesta->Monto4, $apuesta->Monto5];
                    $caballos = [$apuesta->Caballo1, $apuesta->Caballo2, $apuesta->Caballo3, $apuesta->Caballo4, $apuesta->Caballo5];
                    foreach ($caballos as $index => $caballoId) {
                        if ($apuestaPollaUser->caballo_id == $caballoId) {
                            $montoApostado = $montos[$index];
                            break;
                        }
                    }

                    $user->Perdio += $montoApostado;
                    $user->Jugo += $montoApostado;
                    $apuestaPollaUser->Resultadoapuesta = 'Perdió';
                }

                $user->save();
                $apuestaPollaUser->save();
            }
        } else {
            $apuestasPollaUsers = $apuesta->apuestaPollaUsers;
            foreach ($apuestasPollaUsers as $apuestaPollaUser) {
                $user = User::find($apuestaPollaUser->user_id);
                $montoADevolver = 0;
                $caballos = [$apuesta->Caballo1, $apuesta->Caballo2, $apuesta->Caballo3, $apuesta->Caballo4, $apuesta->Caballo5];
                $montos = [$apuesta->Monto1, $apuesta->Monto2, $apuesta->Monto3, $apuesta->Monto4, $apuesta->Monto5];

                foreach ($caballos as $index => $caballoId) {
                    if ($apuestaPollaUser->caballo_id == $caballoId) {
                        $montoADevolver = $montos[$index];
                        break;
                    }
                }

                $user->saldo += $montoADevolver;
                $apuestaPollaUser->Resultadoapuesta = 'Cancelada';
                $user->save();
                $apuestaPollaUser->save();
            }
        }
    }
} else {
 
}
   return redirect()->route('carreras.index', $carrera)
                     ->with('success', 'La carrera polla se ha cerrado correctamente.');
}
*/
public function cerrar(Request $request, Carrera $carrera): RedirectResponse {
    $carrera->estado = 1;
    $carrera->save();

    // Obtener los resultados de los caballos de la carrera
    $resultados = $carrera->caballos()->wherePivot('carrera_id', $carrera->id)->pluck('resultado', 'id');
    $numCaballos = $carrera->caballos()->count();

    // Establecer las fechas de INICIO y FIN
    Carbon::setLocale('es');
    $inicio = Carbon::now()->previous(Carbon::WEDNESDAY);
    $fin = Carbon::now()->next(Carbon::TUESDAY);
    $semana = $inicio->isoFormat('D [al] ') . $fin->isoFormat('D [de] MMMM');

    $usuariosProcesados = [];

    if ($numCaballos == 2) {
        foreach ($resultados as $caballoId => $resultado) {
            $apuestas = ApuestamanomanoUser::whereHas('apuestamanomano', function ($query) use ($carrera) {
                $query->where('carrera_id', $carrera->id);
            })->where('caballo_id', $caballoId)->get();

            foreach ($apuestas as $apuesta) {
                $user = User::find($apuesta->user_id);
                $userId = $apuesta->user_id;
                $apuestasManoMano = ApuestamanomanoUser::where('apuestamanomano_id', $apuesta->apuestamanomano_id)
                    ->orderBy('id')
                    ->get();

                if ($apuestasManoMano->count() == 2) {
                    if ($apuesta->id == $apuestasManoMano->first()->id) {
                        $tipo = $apuesta->apuestamanomano->Tipo;
                    } else {
                        if ($apuestasManoMano->first()->Tipo == 'recibo') {
                            $tipo = 'doy';
                        } elseif ($apuestasManoMano->first()->Tipo == 'doy') {
                            $tipo = 'recibo';
                        } else {
                            $tipo = $apuestasManoMano->first()->Tipo;
                        }
                    }
                }

                if (!in_array($userId, $usuariosProcesados)) {
                    $usuariosProcesados[] = $userId;

                    $historialUser = HistorialUser::where('user_id', $userId)
                        ->whereDate('INICIO', $inicio->toDateString())
                        ->whereDate('FIN', $fin->toDateString())
                        ->first();

                    if (!$historialUser) {
                        // Obtener el saldo final de la semana anterior
                        $historialUserAnterior = HistorialUser::where('user_id', $userId)
                            ->whereDate('INICIO', '<', $inicio->toDateString())
                            ->orderBy('INICIO', 'desc')
                            ->first();

                        $SaldoAnterior = $historialUserAnterior ? $historialUserAnterior->SaldoFinal : 0;

                        $historialUser = new HistorialUser([
                            'user_id' => $userId,
                            'INICIO' => $inicio->toDateString(),
                            'FIN' => $fin->toDateString(),
                            'semana' => $semana,
                            'gano' => 0,
                            'perdio' => 0,
                            'comision' => 0,
                            'total_depositado' => 0,
                            'a_depositar' => 0,
                            'saldo' => 0,
                            'SALDO_POSITIVO' => 0,
                            'SALDO_NEGATIVO' => 0,
                            'SaldoAnterior' => $SaldoAnterior,
                            'Diferencia' => 0,
                            'SaldoFinal' => 0,
                        ]);
                        $historialUser->save();
                    }
                } else {
                    $historialUser = HistorialUser::where('user_id', $userId)
                        ->whereDate('INICIO', $inicio->toDateString())
                        ->whereDate('FIN', $fin->toDateString())
                        ->first();
                }

                $montoTotal = $apuesta->apuestamanomano->Monto1 + $apuesta->apuestamanomano->Monto2;

                if ($apuesta->caballo_id == $caballoId) {
                    if ($resultado == 1) {
                        if ($apuesta->apuestamanomano->Tipo == "recibo") {
                            $historialUser->gano += $apuesta->apuestamanomano->Monto1;
                            $historialUser->comision += $apuesta->apuestamanomano->Monto1 * 0.05;
                            $historialUser->a_depositar += $apuesta->apuestamanomano->Monto2;

                            $user->Gano += $apuesta->apuestamanomano->Monto1;
                            $user->Comision += $apuesta->apuestamanomano->Monto1 * 0.05;
                            $user->Jugo += $apuesta->apuestamanomano->Monto2;
                            $apuesta->resultadoapuesta = 'Ganó';
                        } else {
                            $historialUser->gano += $apuesta->apuestamanomano->Monto2;
                            $historialUser->comision += $apuesta->apuestamanomano->Monto2 * 0.05;
                            $user->Gano += $apuesta->apuestamanomano->Monto2;
                            $user->Comision += $apuesta->apuestamanomano->Monto2 * 0.05;
                            $user->Jugo += $apuesta->apuestamanomano->Monto1;
                            $historialUser->a_depositar += $apuesta->apuestamanomano->Monto1;

                            $apuesta->resultadoapuesta = 'Ganó';
                        }
                    } else if ($resultado == 0) {
                        if ($apuesta->apuestamanomano->Tipo == "recibo") {
                            $user->saldo += $apuesta->apuestamanomano->Monto1;
                            $apuesta->resultadoapuesta = 'Empate';
                        } else {
                            $user->saldo += $apuesta->apuestamanomano->Monto2;
                            $apuesta->resultadoapuesta = 'Empate';
                        }
                    } else {
                        if ($apuesta->apuestamanomano->Tipo == "recibo") {
                            $historialUser->perdio += $apuesta->apuestamanomano->Monto1;
                            $user->Perdio += $apuesta->apuestamanomano->Monto1;
                            $user->Jugo += $apuesta->apuestamanomano->Monto1;
                            $historialUser->a_depositar += $apuesta->apuestamanomano->Monto1;

                            $apuesta->resultadoapuesta = 'Perdió';
                        } else {
                            $historialUser->perdio += $apuesta->apuestamanomano->Monto2;
                            $user->Perdio += $apuesta->apuestamanomano->Monto2;
                            $user->Jugo += $apuesta->apuestamanomano->Monto2;
                            $historialUser->a_depositar += $apuesta->apuestamanomano->Monto2;

                            $apuesta->resultadoapuesta = 'Perdió';
                        }
                    }
                }

                $user->save();
                $apuesta->save();
                $historialUser->save();
            }
        }

        foreach ($usuariosProcesados as $userId) {
            $historialUser = HistorialUser::where('user_id', $userId)
                ->whereDate('INICIO', $inicio->toDateString())
                ->whereDate('FIN', $fin->toDateString())
                ->first();

            if ($historialUser) {
                $historialUser->gano = $historialUser->gano ?? 0;
                $historialUser->comision = $historialUser->comision ?? 0;
                $historialUser->perdio = $historialUser->perdio ?? 0;
                $historialUser->total_depositado = $historialUser->total_depositado ?? 0;
                $historialUser->a_depositar = $historialUser->a_depositar ?? 0;
                $historialUser->saldo = $historialUser->saldo ?? 0;

                $diferencia = $historialUser->saldo - $historialUser->SALDO_NEGATIVO + $historialUser->SALDO_POSITIVO;

                $historialUser->Diferencia = $diferencia;

                if ($diferencia > 0) {
                    $historialUser->SALDO_POSITIVO = $diferencia;
                    $historialUser->SALDO_NEGATIVO = 0;
                } else {
                    $historialUser->SALDO_NEGATIVO = abs($diferencia);
                    $historialUser->SALDO_POSITIVO = 0;
                }

                $historialUser->SaldoFinal = $historialUser->saldo;

                $historialUser->save();
            }
        }
    }

    if ($numCaballos >= 3) {
        $apuestasPolla = $carrera->apuestaPollas()->withCount('apuestaPollaUsers')->get();
        $caballoGanadorId = $carrera->caballos()->wherePivot('resultado', 1)->value('id');

        foreach ($apuestasPolla as $apuesta) {
            if ($apuesta->apuesta_polla_users_count >= 3) {
                foreach ($apuesta->apuestaPollaUsers as $apuestaPollaUser) {
                    $user = User::find($apuestaPollaUser->user_id);
                    $montoApostado = 0;
                    $gananciaTotal = 0;

                    if ($apuestaPollaUser->caballo_id == $caballoGanadorId) {
                        $montos = [$apuesta->Monto1, $apuesta->Monto2, $apuesta->Monto3, $apuesta->Monto4, $apuesta->Monto5];
                        $caballos = [$apuesta->Caballo1, $apuesta->Caballo2, $apuesta->Caballo3, $apuesta->Caballo4, $apuesta->Caballo5];

                        foreach ($caballos as $index => $caballoId) {
                            if ($caballoId != 0 && $caballoId != $caballoGanadorId && $apuestaPollaUser->caballo_id != $caballoId) {
                                $hayApuestas = ApuestaPollaUser::where('caballo_id', $caballoId)->exists();
                                if ($hayApuestas) {
                                    $gananciaTotal += $montos[$index];
                                }
                            }
                            if ($apuestaPollaUser->caballo_id == $caballoId) {
                                $montoApostado = $montos[$index];
                            }
                        }

                        $user->Gano += $gananciaTotal;
                        $user->Comision += $gananciaTotal * 0.05;
                        $user->Jugo += $montoApostado;
                        $apuestaPollaUser->Resultadoapuesta = 'Ganó';
                    } else {
                        $montos = [$apuesta->Monto1, $apuesta->Monto2, $apuesta->Monto3, $apuesta->Monto4, $apuesta->Monto5];
                        $caballos = [$apuesta->Caballo1, $apuesta->Caballo2, $apuesta->Caballo3, $apuesta->Caballo4, $apuesta->Caballo5];
                        foreach ($caballos as $index => $caballoId) {
                            if ($apuestaPollaUser->caballo_id == $caballoId) {
                                $montoApostado = $montos[$index];
                                break;
                            }
                        }

                        $user->Perdio += $montoApostado;
                        $user->Jugo += $montoApostado;
                        $apuestaPollaUser->Resultadoapuesta = 'Perdió';
                    }

                    $user->save();
                    $apuestaPollaUser->save();

                    // Registro en HistorialUser
                    if (!in_array($user->id, $usuariosProcesados)) {
                        $usuariosProcesados[] = $user->id;

                        $historialUser = HistorialUser::where('user_id', $user->id)
                            ->whereDate('INICIO', $inicio->toDateString())
                            ->whereDate('FIN', $fin->toDateString())
                            ->first();

                        if (!$historialUser) {
                            // Obtener el saldo final de la semana anterior
                            $historialUserAnterior = HistorialUser::where('user_id', $user->id)
                                ->whereDate('INICIO', '<', $inicio->toDateString())
                                ->orderBy('INICIO', 'desc')
                                ->first();

                            $SaldoAnterior = $historialUserAnterior ? $historialUserAnterior->SaldoFinal : 0;

                            $historialUser = new HistorialUser([
                                'user_id' => $user->id,
                                'INICIO' => $inicio->toDateString(),
                                'FIN' => $fin->toDateString(),
                                'semana' => $semana,
                                'gano' => 0,
                                'perdio' => 0,
                                'comision' => 0,
                                'total_depositado' => 0,
                                'a_depositar' => 0,
                                'saldo' => 0,
                                'SALDO_POSITIVO' => 0,
                                'SALDO_NEGATIVO' => 0,
                                'SaldoAnterior' => $SaldoAnterior,
                                'Diferencia' => 0,
                                'SaldoFinal' => 0,
                            ]);
                            $historialUser->save();
                        }
                    } else {
                        $historialUser = HistorialUser::where('user_id', $user->id)
                            ->whereDate('INICIO', $inicio->toDateString())
                            ->whereDate('FIN', $fin->toDateString())
                            ->first();
                    }

                    if ($apuestaPollaUser->Resultadoapuesta == 'Ganó') {
                        $historialUser->gano += $gananciaTotal;
                        $historialUser->comision += $gananciaTotal * 0.05;
                        $historialUser->a_depositar += $montoApostado;
                    } else {
                        $historialUser->perdio += $montoApostado;
                        $historialUser->a_depositar += $montoApostado;
                    }

                    $historialUser->save();
                }
            } else {
                $apuestasPollaUsers = $apuesta->apuestaPollaUsers;
                foreach ($apuestasPollaUsers as $apuestaPollaUser) {
                    $user = User::find($apuestaPollaUser->user_id);
                    $montoADevolver = 0;
                    $caballos = [$apuesta->Caballo1, $apuesta->Caballo2, $apuesta->Caballo3, $apuesta->Caballo4, $apuesta->Caballo5];
                    $montos = [$apuesta->Monto1, $apuesta->Monto2, $apuesta->Monto3, $apuesta->Monto4, $apuesta->Monto5];

                    foreach ($caballos as $index => $caballoId) {
                        if ($apuestaPollaUser->caballo_id == $caballoId) {
                            $montoADevolver = $montos[$index];
                            break;
                        }
                    }

                    $user->saldo += $montoADevolver;
                    $apuestaPollaUser->Resultadoapuesta = 'Cancelada';
                    $user->save();
                    $apuestaPollaUser->save();
                }
            }
        }

        // Finalizar y ajustar los valores en HistorialUser
        foreach ($usuariosProcesados as $userId) {
            $historialUser = HistorialUser::where('user_id', $userId)
                ->whereDate('INICIO', $inicio->toDateString())
                ->whereDate('FIN', $fin->toDateString())
                ->first();

            if ($historialUser) {
                $historialUser->gano = $historialUser->gano ?? 0;
                $historialUser->comision = $historialUser->comision ?? 0;
                $historialUser->perdio = $historialUser->perdio ?? 0;
                $historialUser->total_depositado = $historialUser->total_depositado ?? 0;
                $historialUser->a_depositar = $historialUser->a_depositar ?? 0;
                $historialUser->saldo = $historialUser->saldo ?? 0;

                $diferencia = $historialUser->saldo - $historialUser->SALDO_NEGATIVO + $historialUser->SALDO_POSITIVO;

                $historialUser->Diferencia = $diferencia;

                if ($diferencia > 0) {
                    $historialUser->SALDO_POSITIVO = $diferencia;
                    $historialUser->SALDO_NEGATIVO = 0;
                } else {
                    $historialUser->SALDO_NEGATIVO = abs($diferencia);
                    $historialUser->SALDO_POSITIVO = 0;
                }

                $historialUser->SaldoFinal = $historialUser->saldo;

                $historialUser->save();
            }
        }
    }

    return redirect()->route('carreras.index', $carrera)
        ->with('success', 'La carrera se ha cerrado correctamente.');
}





public function cerrarapuesta(Request $request, Carrera $carrera): RedirectResponse {
    // Obtener los resultados de los caballos de la carrera
    $resultados = $carrera->caballos()->wherePivot('carrera_id', $carrera->id)->pluck('resultado', 'id');

    // Obtener las apuestas polla de la carrera
    $apuestas_polla = $carrera->apuestaPollas;

    // Recorrer las apuestas polla
    foreach ($apuestas_polla as $apuesta_polla) {
        // Obtener los usuarios que participaron en la apuesta
        $usuarios_polla = $apuesta_polla->apuestaPollaUsers;

        // Obtener los caballos que se apostaron
        $caballos_polla = [];
        for ($i = 1; $i <= 5; $i++) {
            $caballo_polla = $apuesta_polla->{"Caballo$i"};
            if ($caballo_polla) {
                $caballos_polla[] = $caballo_polla;
            }
        }

        // Obtener los montos que se apostaron
        $montos_polla = [];
        for ($i = 1; $i <= 5; $i++) {
            $caballo_nombre = $apuesta_polla->apuestaPollaUsers->where('caballo_id', $apuesta_polla->{"Caballo$i"})->first()->caballo->nombre;
            $monto_polla = $apuesta_polla->{"Monto$i"};
            if ($monto_polla) {
                $montos_polla[$caballo_nombre] = $monto_polla;
            }
        }

        // Si hay al menos 3 caballos que se apostaron
        if (count($caballos_polla) >= 3) {
            // Obtener los resultados de los caballos que se apostaron
            $resultados_apuesta_polla = [];
            foreach ($caballos_polla as $caballo_polla) {
                $resultados_apuesta_polla[$caballo_polla] = $resultados[$caballo_polla];
            }

            // Ordenar los resultados de los caballos que se apostaron de menor a mayor
            asort($resultados_apuesta_polla);

            // Obtener el caballo que tiene el mejor resultado entre los que se apostaron
            $caballo_ganador_polla = array_key_first($resultados_apuesta_polla);

            // Obtener el usuario que apostó por el caballo ganador
            $usuario_ganador_polla = $usuarios_polla->where('caballo_id', $caballo_ganador_polla)->first();

            // Si hay un usuario que apostó por el caballo ganador
            if ($usuario_ganador_polla) {
                // Obtener el monto que apostó el usuario ganador
                $monto_ganador_polla = $montos_polla[$caballo_ganador_polla];

                // Calcular el premio del usuario ganador
                $premio_polla = array_sum($montos_polla);

                // Calcular la comisión del usuario ganador
                $comision_polla = $premio_polla * 0.025;

                // Actualizar el saldo, ganancia y comisión del usuario ganador
                $usuario_ganador_polla->user->saldo += $premio_polla;
                $usuario_ganador_polla->user->Gano += $premio_polla;
                $usuario_ganador_polla->user->Comision += $comision_polla;
                $usuario_ganador_polla->user->save();

                // Actualizar el resultado de la apuesta del usuario ganador
                $usuario_ganador_polla->Resultadoapuesta = 'Gano';
                $usuario_ganador_polla->save();

                // Actualizar la ganancia de la apuesta
                $apuesta_polla->Ganancia = $premio_polla;
                $apuesta_polla->save();

                // Recorrer los demás usuarios que participaron en la apuesta
                foreach ($usuarios_polla as $usuario_polla) {
                    // Si el usuario no es el ganador
                    if ($usuario_polla->id != $usuario_ganador_polla->id) {
                        // Obtener el caballo y el monto que apostó el usuario
                        $caballo_polla = $usuario_polla->caballo_id;
                        $monto_polla = $montos_polla[$caballo_polla];

                        // Actualizar la pérdida del usuario
                        $usuario_polla->user->Perdio += $monto_polla;
                        $usuario_polla->user->save();

                        // Actualizar el resultado de la apuesta del usuario
                        $usuario_polla->Resultadoapuesta = 'Perdio';
                        $usuario_polla->save();
                    }
                }
            } else {
                // Si no hay ningún usuario que apostó por el caballo ganador, no hacer nada
            }
        } else {
            // Si hay menos de 3 caballos que se apostaron, cancelar la apuesta y devolver el dinero
            foreach ($usuarios_polla as $usuario_polla) {
                // Obtener el caballo y el monto que apostó el usuario
                $caballo_polla = $usuario_polla->caballo_id;
                $monto_polla = $montos_polla[$caballo_polla];

                // Actualizar el saldo del usuario
                $usuario_polla->user->saldo += $monto_polla;
                $usuario_polla->user->save();

                // Actualizar el resultado de la apuesta del usuario
                $usuario_polla->Resultadoapuesta = 'Cancelada';
                $usuario_polla->save();
            }

            // Actualizar la ganancia de la apuesta
            $apuesta_polla->Ganancia = 0;
            $apuesta_polla->save();
        }
    }

    // Actualizar el estado de la carrera
    $carrera->estado = false;
    $carrera->save();

    // Redireccionar a la vista de la carrera con un mensaje de éxito
    return redirect()->route('carreras.index', $carrera)->with('success', 'La carrera se ha cerrado correctamente.');
}




public function destroy(Request $request, Carrera $carrera): RedirectResponse {
    $this->authorize('delete', $carrera);

    // Cambiar el estado de la carrera a 'Eliminada'
    $carrera->estado = 'Cancelada';
    $carrera->save();

    return redirect()
        ->route('carreras.index')
        ->withSuccess(__('Carrera marcada como eliminada'));
}


}
