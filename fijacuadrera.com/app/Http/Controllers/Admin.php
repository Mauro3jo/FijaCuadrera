<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Caballo;

use App\Models\Apuestamanomano;
use App\Models\ApuestamanomanoUser;
use App\Models\ApuestaPollaUser;
use App\Models\LlaveUser;
use App\Models\Llave;
use App\Models\ApuestaPolla;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class Admin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Obtener todas las apuestas mano a mano con sus relaciones anidadas
    $apuestasManoMano = Apuestamanomano::with([
        'carrera',
        'apuestamanomanoUsers.user',
        'apuestamanomanoUsers.caballo'
    ])->get();

    // Obtener todas las apuestas polla con sus relaciones anidadas
    $apuestasPolla = ApuestaPolla::with([
        'carrera',
        'apuestaPollaUsers.user',
        'apuestaPollaUsers.caballo'
    ])->get();

    // Pasar los datos a la vista
    return view('Admin.ApuestasArmadas', compact('apuestasManoMano', 'apuestasPolla'));
}

/*public function index2()
{
    // Obtener todas las apuestas mano a mano
    $apuestasManoAMano = ApuestamanomanoUser::get();
    
    // Obtener todas las llaves
    $llaves = LlaveUser::with('llave')->get();

    // Iterar sobre las apuestas mano a mano para modificar según necesidad
    foreach ($apuestasManoAMano as $apuesta) {
        $apuestaManoAMano = $apuesta->apuestamanomano;
        $apuestasRelacionadas = $apuestaManoAMano->apuestamanomanoUsers;

        if ($apuesta->id !== $apuestasRelacionadas->first()->id) {
            $apuestaManoAMano->Tipo = $apuestaManoAMano->Tipo === 'doy' ? 'recibo' : 'doy';
        }
        // No es necesario verificar la igualdad en este punto, ya que la condición anterior cubre todos los casos posibles
        else {
            $apuestaManoAMano->Tipo = $apuestaManoAMano->Tipo;
        }

        if ($apuesta->id !== $apuestasRelacionadas->first()->id) {
            $apuestaManoAMano->Caballo1 = $apuestaManoAMano->Caballo2;
        }
    }

    // Obtener todas las apuestas de polla
    $apuestasPolla = ApuestaPollaUser::get();

    // Crear un array para almacenar los resultados consolidados
    $resultadosApuestasPolla = [];

    foreach ($apuestasPolla as $apuestaPollaUser) {
        $apuestaPolla = $apuestaPollaUser->apuestaPolla;
        $id = $apuestaPolla->id;

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

                $resultadosApuestasPolla[$id]['caballos'][$caballoId] = $nombreCaballo;
                $resultadosApuestasPolla[$id]['montos'][$caballoId] = $monto;
                $resultadosApuestasPolla[$id]['estado'][$caballoId] = $estado;

                if ($apuestaPollaUser->caballo_id == $caballoId) {
                    $resultadosApuestasPolla[$id]['CaballoJugado'][$caballoId] = $nombreCaballo;
                    $resultadosApuestasPolla[$id]['resultado_apuesta'][$caballoId] = $apuestaPollaUser->Resultadoapuesta;
                    $resultadosApuestasPolla[$id]['a_depositar'][$caballoId] = $monto;
                }
            }
        }
    }

    // Pasar los datos a la vista
    //return view('Admin.ApuestasArmadas2', compact('apuestasManoAMano', 'apuestasPolla', 'llaves'));
    return view('Admin.ApuestasArmadas2', [
        'apuestasManoAMano' => $apuestasManoAMano,
        'apuestasPolla' => $resultadosApuestasPolla, // Pasar el array de resultados
        'llaves' => $llaves,
    ]);
    }
*/

public function index2()
{
    // Obtener todas las apuestas mano a mano
// Obtener todas las apuestas mano a mano con la información del caballo
$apuestasManoAMano = ApuestamanomanoUser::with('apuestamanomano', 'user', 'caballo')->get();    
    // Obtener todas las llaves con usuarios
    $llaves = LlaveUser::with('llave')->get();
    $userIds = $llaves->pluck('user_id')->unique();
    $users = User::whereIn('id', $userIds)->get()->keyBy('id');

    // Agregar el nombre del usuario a cada llave
    $llaves->each(function ($item) use ($users) {
        $item->nombre_usuario = $users[$item->user_id]->name ?? 'Usuario no encontrado';
    });


// Iterar sobre las apuestas mano a mano para modificar según necesidad
foreach ($apuestasManoAMano as $apuesta) {
    $apuestaManoAMano = $apuesta->apuestamanomano;
    $apuestasRelacionadas = $apuestaManoAMano->apuestamanomanoUsers;

    // Asignar el tipo de apuestamanomano al objeto apuestamanomanoUser para la vista
    $apuesta->Tipo = $apuestaManoAMano->Tipo;

    // Asignar el nombre del caballo al objeto apuestamanomanoUser para la vista
    $apuesta->NombreCaballo = $apuesta->caballo->nombre ?? 'Caballo no encontrado';

    // Verificar si el objeto actual es el segundo ApuestamanomanoUser relacionado
    if ($apuestasRelacionadas->count() > 1 && $apuestasRelacionadas[1]->id == $apuesta->id) {
        // Si hay un segundo ApuestamanomanoUser, cambiar el tipo basado en el tipo de Apuestamanomano
        if ($apuestaManoAMano->Tipo == 'doy') {
            $apuesta->Tipo = 'recibo'; // Cambio solo para la vista
        } elseif ($apuestaManoAMano->Tipo == 'recibo') {
            $apuesta->Tipo = 'doy'; // Cambio solo para la vista
        }
    }
}









    // Obtener todas las apuestas de polla
$apuestasPolla = ApuestaPollaUser::with('apuestaPolla', 'user')->get();

// Crear un array para almacenar los resultados consolidados
$resultadosApuestasPolla = [];
foreach ($apuestasPolla as $apuestaPollaUser) {
    $apuestaPolla = $apuestaPollaUser->apuestaPolla;
    $id = $apuestaPolla->id;
    $userId = $apuestaPollaUser->user->id; // Identificador del usuario

    // Clave única para cada combinación de apuesta de polla y usuario
    $claveUnica = $id . '-' . $userId;

    if (!isset($resultadosApuestasPolla[$claveUnica])) {
        $resultadosApuestasPolla[$claveUnica] = [
            'apuesta_polla_id' => $id,
            'user_id' => $userId,
            'nombre_usuario' => $apuestaPollaUser->user->name,
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
            $estado = $apuestaPolla->{"Estado$i"} == true ? 'Jugada' : 'Pendiente';

            $resultadosApuestasPolla[$claveUnica]['caballos'][$i] = $nombreCaballo;
            $resultadosApuestasPolla[$claveUnica]['montos'][$i] = $monto;
            $resultadosApuestasPolla[$claveUnica]['estado'][$i] = $estado;

            if ($apuestaPollaUser->caballo_id == $caballoId) {
                $resultadosApuestasPolla[$claveUnica]['CaballoJugado'][$i] = $nombreCaballo;
                $resultadosApuestasPolla[$claveUnica]['resultado_apuesta'][$i] = $apuestaPollaUser->Resultadoapuesta;
                $resultadosApuestasPolla[$claveUnica]['a_depositar'][$i] = $monto;
            }
        }
    }
}
    // Pasar los datos a la vista
    return view('Admin.ApuestasArmadas2', [
        'apuestasManoAMano' => $apuestasManoAMano,
        'apuestasPolla' => $resultadosApuestasPolla,
        'llaves' => $llaves,
    ]);
}



     public function listadoUsuarios(Request $request): View
     {
         $users = User::all(); // Obtener todos los usuarios
     
         return view('Admin.UsuariosAdmin', compact('users'));
     }
     
     public function procesarDeuda($id, $accion)
     {
         // Busca al usuario por el id
         $user = User::find($id);
     
         // Verifica que el usuario exista
         if ($user) {
             // Verifica el tipo de acción
             if ($accion == 'pagar') {
                 // Lógica para pagar la deuda
                 $user->Gano = 0;
                 $user->Perdio = 0;
                 $user->Comision = 0;
                 $user->Jugo = 0;
                 $user->save();
     
                 // Retorna una respuesta exitosa
                 return response()->json(['success' => 'Deuda pagada exitosamente']);
             } elseif ($accion == 'recibir') {
                 // Lógica para recibir la deuda
                 // Aquí debes poner tu código
                 $user->Gano = 0;
                 $user->Perdio = 0;
                 $user->Comision = 0;
                 $user->Jugo = 0;
                 $user->save();
                 // Retorna una respuesta exitosa
                 return response()->json(['success' => 'Deuda recibida exitosamente']);
             } else {
                 // Retorna una respuesta de error
                 return response()->json(['error' => 'Acción inválida']);
             }
         } else {
             // Retorna una respuesta de error
             return response()->json(['error' => 'Usuario no encontrado']);
         }
     }
     
 
    
  
}
