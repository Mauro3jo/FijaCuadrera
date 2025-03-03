<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\ApuestamanomanoUser;
use App\Models\ApuestaPolla;
use App\Models\ApuestaPollaUser;
use App\Models\Carrera; // Importa el modelo Carrera
use Illuminate\Http\Request;

class SalonesController extends Controller
{
    public function mostrarTodasLasApuestas()
    {
        // Obtener todas las carreras
        $carreras = Carrera::with('apuestamanomanos', 'apuestaPollas', 'caballos')->get();

        // Filtrar las carreras activas (estado diferente de 1)
        $carrerasActivas = $carreras->filter(function ($carrera) {
            return $carrera->estado != 1;
        });

        // Obtener las apuestas mano a mano que están inactivas (Estado = 0) y cargar los datos relacionados, solo para las carreras activas
        $apuestasManoMano = ApuestamanomanoUser::whereHas('apuestamanomano', function ($query) use ($carrerasActivas) {
            $query->whereIn('carrera_id', $carrerasActivas->pluck('id'))
                  ->where('Estado', 0); // Filtrar por Estado = 0
        })->with('apuestamanomano', 'caballo', 'apuestamanomano.carrera')->get();

        // Obtener las apuestas pollas que están inactivas y cargar los datos relacionados, solo para las carreras activas
        $apuestasPolla = ApuestaPolla::where('Estado', 0)->whereHas('apuestaPollaUsers')->with('apuestaPollaUsers')->get();

        // Obtener caballos para cada carrera
        $caballos = $carreras->pluck('caballos')->flatMap(function ($caballos) {
            return $caballos->pluck('nombre', 'id');
        });

        // Retornar la vista con todas las apuestas y carreras
        return view('Salones', ['apuestasManoMano' => $apuestasManoMano, 'apuestasPolla' => $apuestasPolla, 'carreras' => $carrerasActivas, 'caballos' => $caballos]);
    }
}
