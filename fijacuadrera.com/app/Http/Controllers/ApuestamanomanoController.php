<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use App\Models\Carrera;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Apuestamanomano;
use App\Models\Caballo;
use App\Models\User;
use App\Models\ApuestamanomanoUser;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ApuestamanomanoStoreRequest;
use App\Http\Requests\ApuestamanomanoUpdateRequest;

class ApuestamanomanoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Apuestamanomano::class);

        $search = $request->get('search', '');

        $apuestamanomanos = Apuestamanomano::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.apuestamanomanos.index',
            compact('apuestamanomanos', 'search')
        );
    }

public function mostrarApuestasManoMano($carrera_id)
{
    // Buscar la carrera con el id dado y cargar los caballos
    $carrera = Carrera::with('caballos')->find($carrera_id);

    // Verificar si la carrera es nula
    if (!$carrera) {
        // Manejar la situación en la que no se encontró la carrera
        abort(404, 'Carrera no encontrada');
    }

    // Obtener un array con los nombres y los ids de los caballos
    $caballos = $carrera->caballos->pluck('nombre', 'id');

    // Obtener las apuestas mano a mano que pertenecen a la carrera y cargar los datos relacionados
    $apuestas = ApuestamanomanoUser::whereHas('apuestamanomano', function ($query) use ($carrera_id) {
      $query->where('carrera_id', $carrera_id);
  })->with('apuestamanomano', 'caballo', 'user', 'apuestamanomano.carrera')->get();
  
    // Agrupar las apuestas por manomano
    $apuestasPorManomano = $apuestas->groupBy('apuestamanomano_id');

    // Obtener el primer dato asociado de apuestamanomanouser por cada manomano
    $primerosDatos = $apuestasPorManomano->map(function ($apuestas) {
      return $apuestas->first();
    });

    // Retornar la vista con la carrera, los caballos, los primeros datos y las apuestas
    return view('ManoMano', ['carrera' => $carrera, 'caballos' => $caballos, 'primerosDatos' => $primerosDatos, 'apuestas' => $primerosDatos]);
}

    
  
   // El backend para recibir el id de la apuesta y realizar la lógica
   public function aceptarApuesta(Request $request, $id)
   {
       $apuestamanomano_id = $request->input('apuestamanomano_id');
       $monto2 = $request->input('monto2');
       // Obtener el id y el saldo del usuario autenticado
       $user_id = auth()->id();
       $saldo = User::find($user_id)->saldo;
       $apuestaMano = Apuestamanomano::find($apuestamanomano_id);
      // $carrera= Carrera::find($apuestaMano->carrera_id);
      // if($carrera->estado=1){
        //              return redirect()->route('carreras.apuestas.manomano', ['id' => $apuestaMano->carrera_id])->with('error', 'No tienes suficiente saldo para apostar');

       //}
       // Verificar si el usuario tiene saldo suficiente para realizar la apuesta
       if ($saldo >= $monto2) {
           // Obtener la información de la apuesta actual
        
   
           // Verificar si hay una ApuestamanomanoUser asociada a la Apuestamanomano actual y si está ocupada
           $apuestaUserExistente = ApuestamanomanoUser::where('apuestamanomano_id', $apuestamanomano_id)
               ->where('resultadoapuesta', 'pendiente')
               ->first();
   
           if ($apuestaUserExistente) {
               // Si hay una ApuestamanomanoUser "libre", actualizarla con los nuevos datos
               $caballoLibre = ($apuestaMano->Caballo1 == $apuestaUserExistente->caballo->nombre) ? $apuestaMano->Caballo2 : $apuestaMano->Caballo1;
               $caballo_id_libre = Caballo::where('nombre', $caballoLibre)->first()->id;
   
               $apuestaUserExistente->create([
                                      'apuestamanomano_id' => $apuestamanomano_id,

                   'user_id' => $user_id,
                   'caballo_id' => $caballo_id_libre,
                   'resultadoapuesta' => 'pendiente',
               ]);
           } else {
               // Si no hay una ApuestamanomanoUser "libre", crear una nueva
               $caballoLibre = ($apuestaMano->Caballo1 == $apuestaMano->Caballo2) ? $apuestaMano->Caballo1 : $apuestaMano->Caballo2;
               $caballo_id_libre = Caballo::where('nombre', $caballoLibre)->first()->id;
   
               ApuestamanomanoUser::create([
                   'apuestamanomano_id' => $apuestamanomano_id,
                   'user_id' => $user_id,
                   'caballo_id' => $caballo_id_libre,
                   'resultadoapuesta' => 'pendiente',
               ]);
           }
   
           // Restar el monto2 al saldo del usuario
           $saldo -= $monto2;
   
           // Actualizar el saldo del usuario
           User::find($user_id)->update(['saldo' => $saldo]);
   
           // Cambiar el estado y el resultado apuesta de la Apuestamanomano a 1 y 'aceptada'
           $apuestaMano->update(['Estado' => 1, 'resultadoapuesta' => 'pendiente']);
   
           // Devolver una respuesta con el mensaje
           return response()->json(['success' => true]);
       } else {
           // Devolver una redirección con el mensaje de error
           return redirect()->route('carreras.apuestas.manomano', ['id' => $apuestaMano->carrera_id])->with('error', 'No tienes suficiente saldo para apostar');
       }
   }
   







   public function guardarApuesta(Request $request, $carrera_id)
   {

 
     $tipo = $request->input('tipo');

     if ($tipo == 'recibo') {
       $monto1 = $request->input('monto1');
       $monto2 = $request->input('monto2');
     } elseif($tipo == 'pago'){
       $monto1 = $request->input('monto1');
       $monto2 = $request->input('monto1');
     }
     else{
       $monto1 = $request->input('monto1');
       $monto2 = $request->input('monto2');
     }
   
   
     $request->validate([
       'caballo1' => 'required|exists:caballos,id', 
       'caballo2' => 'required|exists:caballos,id', 
       'tipo' => 'required|in:pago,doy,recibo',
       'monto1' => 'required|numeric',
       'monto2' => 'requiredIf:tipo,doy,recibo|numeric'
     ]);
   
    
     $caballo1 = $request->input('caballo1');
     $caballo2 = $request->input('caballo2');
   
   
   
     $user_id = auth()->id();
   
    
     $saldo = User::find($user_id)->saldo;
   
     
     if ($saldo < $monto1) {
      
       return redirect()->route('carreras.apuestas.manomano', ['id' => $carrera_id])->with('error', 'No tienes suficiente saldo para apostar');
     }
   
    
     User::find($user_id)->decrement('saldo', $monto1);
   
     
     if ($tipo == 'pago') {
       
       $apuesta_invertida = Apuestamanomano::where('carrera_id', $carrera_id)
         ->where('tipo', 'pago')
         ->where('caballo1', Caballo::find($caballo2)->nombre) 
         ->where('caballo2', Caballo::find($caballo1)->nombre) 
         ->where('monto1', $monto1) 
         ->where('monto2', $monto1) 
         ->where('estado', false)
         ->orderBy('id') 
         ->first(); 
     } elseif ($tipo == 'doy') {
      
       $apuesta_invertida = Apuestamanomano::where('carrera_id', $carrera_id)
         ->where('tipo', 'recibo')
         ->where('caballo1', Caballo::find($caballo2)->nombre) 
         ->where('caballo2', Caballo::find($caballo1)->nombre) 
         ->where('monto1', $monto1) 
         ->where('monto2', $monto2) 
         ->where('estado', false)
         ->orderBy('id') 
         ->first(); 
     } else {
       
       $apuesta_invertida = Apuestamanomano::where('carrera_id', $carrera_id)
         ->where('tipo', 'doy')
         ->where('caballo1', Caballo::find($caballo2)->nombre) 
         ->where('caballo2', Caballo::find($caballo1)->nombre) 
         ->where('monto1', $monto1) 
         ->where('monto2', $monto2) 
         ->where('estado', false)
         ->orderBy('id') 
         ->first(); 
     }
   
   
     if ($apuesta_invertida) {
  // Crear la apuesta invertida
  ApuestamanomanoUser::create([
    'apuestamanomano_id' => $apuesta_invertida->id,
    'user_id' => $user_id,
    'caballo_id' => $caballo1, 
    'resultadoapuesta' => "pendiente" 
  ]);
  // Obtener las apuestas asociadas
//  $apuestas_asociadas = ApuestamanomanoUser::where('apuestamanomano_id', $apuesta_invertida->id)->get();
  // Recorrer las apuestas asociadas y cambiar el resultado
  //foreach ($apuestas_asociadas as $apuesta) {
 //   $apuesta->update(['resultadoapuesta' => "Jugada"]);
  //}


   
      
       $apuesta_invertida->update(['Estado' => true]);
     } else {
       
       $apuesta = Apuestamanomano::create([
         'carrera_id' => $carrera_id,
         'Ganancia' => ($monto1 + $monto2) * 0.5, 
         'Caballo1' => Caballo::find($caballo1)->nombre, 
         'Caballo2' => Caballo::find($caballo2)->nombre, 
         'Monto1' => $monto1,
         'Monto2' => $monto2, 
         'Tipo' => $tipo,
         'Estado' => false 
       ]);
   
      
       ApuestamanomanoUser::create([
         'apuestamanomano_id' => $apuesta->id,
         'user_id' => $user_id,
         'caballo_id' => $caballo1, 
         'resultadoapuesta' => "pendiente" 
       ]);
     }
   
    
     return response()->json(['success' => true]);
   }
   
   
   
}
