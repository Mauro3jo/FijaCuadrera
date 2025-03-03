<?php

namespace App\Http\Controllers;

use App\Models\Llave;
use App\Models\LlaveUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Caballo;
class LlaveController extends Controller
{
    public function index()
{
    $llaves = Llave::all();

    foreach ($llaves as $llave) {
        $llaveUsers = LlaveUser::where('llave_id', $llave->id)->get();

        foreach ($llaveUsers as $llaveUser) {
            $user = User::find($llaveUser->user_id);
            $llaveUser->userName = $user->name;
            $llaveUser->userDni = $user->dni;
        }

        $llave->llaveUsers = $llaveUsers;
        //dd($llave);
    }

    // Verifica si el usuario está definido o no
    if (isset($user)) {
        // Si está definido, envía el usuario a la vista
        return view('Llaves.llave', compact('llaves'))->with('user', $user);
    } else {
        // Si no está definido, envía solo las llaves a la vista
        return view('Llaves.llave', compact('llaves'));
    }
}

    
public function index2()
{
    $llaves = Llave::all();

    foreach ($llaves as $llave) {
        $llaveUsers = LlaveUser::where('llave_id', $llave->id)->get();

        // Crear un vector vacío para almacenar los nombres de las parejas
        $vector = [];

        // Crear un contador para llevar el índice del vector
        $contador = 0;

        // Crear un bucle for que recorra los ids de los caballos de dos en dos
        for ($i = 1; $i <= 10; $i++) {
            // Obtener el nombre del primer caballo de la pareja usando el método where()
     $caballo_1 = Caballo::where('id', $llave->{"caballo_1_$i"})->first()->nombre ?? '';

// Obtener el nombre del segundo caballo de la pareja usando el método where()
// Si el resultado es null, asignar una cadena vacía
$caballo_2 = Caballo::where('id', $llave->{"caballo_2_$i"})->first()->nombre ?? '';

            // Verificar si alguno de los nombres es null, lo que significa que no hay más parejas
            if ($caballo_1 == null || $caballo_2 == null) {
                // Salir del bucle
                break;
            }

            // Concatenar los nombres de los caballos y guardarlos en el vector
            $vector[$contador] = 'C' . ($contador + 1) . ' ' . $caballo_1 . ' vs ' . $caballo_2;


            // Incrementar el contador
            $contador++;
        }

        // Asignar el vector a un atributo del llave
        $llave->parejas = $vector;

        foreach ($llaveUsers as $llaveUser) {
            $user = User::find($llaveUser->user_id);
            $llaveUser->userName = $user->name;
            $llaveUser->userDni = $user->dni;
        }

        $llave->llaveUsers = $llaveUsers;
       // dd($vector);
    }

    return view('llave_user', compact('llaves'));
}


    public function create()
    {
        $caballos = Caballo::all();

        return view('Llaves.Crearllave', compact('caballos'));
    }
    public function store(Request $request)
{
    $llave = Llave::create($request->all());
// Asigna el estado Pendiente a la llave
$llave->estado = 'Pendiente';

// Guarda la llave en la base de datos
$llave->save();
    $carreras = [];
    for ($i = 1; $i <= 10; $i++) {
        if ($request->has("caballo_1_$i") && $request->input("caballo_1_$i") != 0 && $request->has("caballo_2_$i") && $request->input("caballo_2_$i") != 0) {
            $caballo_1 = Caballo::find($request->input("caballo_1_$i"))->nombre;
            $caballo_2 = Caballo::find($request->input("caballo_2_$i"))->nombre;
            $carreras[] = [$caballo_1, $caballo_2];
        }
    }

    $combinaciones = $this->getCombinaciones($carreras);

    foreach ($combinaciones as $combinacion) {
        LlaveUser::create([
            'llave_id' => $llave->id,
            'user_id' => auth()->id(),
            'combinacion' => implode(',', $combinacion),
            'estado' => 'Vacante',
        ]);
    }

    return redirect('/llaves');
}

    
private function getCombinaciones($carreras)
{
    $resultados = array(array());

    foreach ($carreras as $carrera) {
        $temp = array();

        foreach ($resultados as $resultado) {
            foreach ($carrera as $caballo) {
                // Verifica si el caballo ya está en la combinación
                if (!in_array($caballo, $resultado)) {
                    $temp[] = array_merge($resultado, array($caballo));
                }
            }
        }

        $resultados = $temp;
    }

    return $resultados;
}
public function comprarLlave(Request $request, $id)
{
    $llaveUser = LlaveUser::find($id);
    $llave = $llaveUser->llave;

    // Verifica si el usuario tiene suficiente saldo para comprar la llave
    if (auth()->user()->saldo >= $llave->valor) {
        // Actualiza el user_id y el estado de la llave
        $llaveUser->update([
            'user_id' => auth()->id(),
            'estado' => 'Vendida',
        ]);

        // Descuenta el valor de la llave del saldo del usuario
        auth()->user()->decrement('saldo', $llave->valor);

        // Verifica si todas las llaves de esa llave tienen el estado de Vendida
        $vendidas = $llave->llaveUser->where('estado', '=', 'Vendida')->count();
        $total = $llave->llaveUser->count();

        // Si todas las llaves están vendidas, actualiza el estado de la llave a Completada
     // Si todas las llaves están vendidas, actualiza el estado de la llave a Completada
     
    
if ($vendidas == $total) {
    $llave->update(['estado' => 'Completada']);

   
}

        return response()->json(['success' => 'Llave comprada con éxito']);
    } else {
        return response()->json(['error' => 'No tienes suficiente saldo para comprar esta llave']);
    }
}

public function ganar($llave_id, $llaveUser_id)
{
    // Buscar la llave por el id
    $llave = Llave::find($llave_id);

    // Buscar la llaveUser por el id
    $llaveUser = LlaveUser::find($llaveUser_id);

    // Buscar el usuario que compró la llave
    //$usuario = $llaveUser->user;
    $usuario = User::find($llaveUser->user_id);
    // Verificar si todas las llaves de esa llave están vendidas o no
    $vendidas = $llave->llaveUser->where('estado', '=', 'Vendida')->count();
    $total = $llave->llaveUser->count();

    // Calcular el premio basado en el valor de la llave y la cantidad de llaves vendidas
    // Si todas las llaves están vendidas, el premio es el valor de la llave multiplicado por el total de llaves
    // Si hay llaves vacantes, el premio es el valor de la llave multiplicado por la cantidad de llaves vendidas menos la cantidad de llaves vacantes
    if ($vendidas == $total) {
        $premio = $llave->premio;
    } else {
        $premio = $llave->premio - ($vendidas* $llave->valor);
    }

    // Actualizar el estado de la llave a finalizada
    $llave->update(['estado' => 'Finalizada']);

    // Actualizar el estado de la llaveUser ganadora a ganador
    $llaveUser->update(['estado' => 'Ganador']);

    // Actualizar el estado de las demás llaves a perdidas
    $llave->llaveUser->where('estado', '=', 'Vendida')->where('id', '!=', $llaveUser->id)->update(['estado' => 'Pierde']);

    // Acreditar el premio al usuario
    $usuario->update(['saldo' => $usuario->saldo + $premio]);

    // Obtener todas las llaves
    $llaves = Llave::all();

    // Asignar los datos de los usuarios y las llaves a cada llave
    foreach ($llaves as $llave) {
        $llaveUsers = LlaveUser::where('llave_id', $llave->id)->get();

        foreach ($llaveUsers as $llaveUser) {
            $user = User::find($llaveUser->user_id);
            $llaveUser->userName = $user->name;
            $llaveUser->userDni = $user->dni;
        }

        $llave->llaveUsers = $llaveUsers;
    }

    // Retornar la vista Llaves.llave con los datos de las llaves y sin mensaje
    return view('Llaves.llave', compact('llaves'))->with('user', $user);
}





    
}
