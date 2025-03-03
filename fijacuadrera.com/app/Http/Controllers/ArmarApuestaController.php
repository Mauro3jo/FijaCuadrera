<?php

namespace App\Http\Controllers;

use App\Models\Apuestamanomano;
use App\Models\ApuestamanomanoUser;
use App\Models\ApuestaPolla;
use App\Models\ApuestaPollaUser;

class ArmarApuestaController extends Controller
{
    public function armarApuestas()
    {
        // Obtener todas las apuestas de tipo Apuestamanomano
        $apuestasManoMano = Apuestamanomano::with(['carrera', 'apuestamanomanoUsers.user'])->get();

        // Obtener todas las apuestas de tipo ApuestaPolla
        $apuestasPolla = ApuestaPolla::with(['carrera', 'apuestaPollaUsers.user'])->get();

        // Crear una estructura de datos combinada para ambas apuestas
        $apuestasCombinadas = [];

        foreach ($apuestasManoMano as $apuestaManoMano) {
            $usuarioCaballo1 = $this->getUsuarioPorNombre($apuestaManoMano->Caballo1, $apuestaManoMano->apuestamanomanoUsers);
            $usuarioCaballo2 = $this->getUsuarioPorNombre($apuestaManoMano->Caballo2, $apuestaManoMano->apuestamanomanoUsers);

            $apuestasCombinadas[] = [
                'id' => $apuestaManoMano->id,
                'tipo' => 'Apuestamanomano',
                'carrera' => $apuestaManoMano->carrera->nombre,
                'caballo1' => $apuestaManoMano->Caballo1,
                'monto1' => $apuestaManoMano->Monto1,
                'usuario_caballo1' => $usuarioCaballo1 ? $usuarioCaballo1->user->name : null,
                'caballo2' => $apuestaManoMano->Caballo2,
                'monto2' => $apuestaManoMano->Monto2,
                'usuario_caballo2' => $usuarioCaballo2 ? $usuarioCaballo2->user->name : null,
                'estado' => $apuestaManoMano->Estado,
                // Otros campos que desees agregar
            ];
        }

        foreach ($apuestasPolla as $apuestaPolla) {
            $usuarioCaballo1 = $this->getUsuarioPorNombre($apuestaPolla->Caballo1, $apuestaPolla->apuestaPollaUsers);
            $usuarioCaballo2 = $this->getUsuarioPorNombre($apuestaPolla->Caballo2, $apuestaPolla->apuestaPollaUsers);
            $usuarioCaballo3 = $this->getUsuarioPorNombre($apuestaPolla->Caballo3, $apuestaPolla->apuestaPollaUsers);
            $usuarioCaballo4 = $this->getUsuarioPorNombre($apuestaPolla->Caballo4, $apuestaPolla->apuestaPollaUsers);
            $usuarioCaballo5 = $this->getUsuarioPorNombre($apuestaPolla->Caballo5, $apuestaPolla->apuestaPollaUsers);

            $apuestasCombinadas[] = [
                'id' => $apuestaPolla->id,
                'tipo' => 'ApuestaPolla',
                'carrera' => $apuestaPolla->carrera->nombre,
                'caballo1' => $apuestaPolla->Caballo1,
                'monto1' => $apuestaPolla->Monto1,
                'usuario_caballo1' => $usuarioCaballo1 ? $usuarioCaballo1->user->name : null,
                'caballo2' => $apuestaPolla->Caballo2,
                'monto2' => $apuestaPolla->Monto2,
                'usuario_caballo2' => $usuarioCaballo2 ? $usuarioCaballo2->user->name : null,
                'caballo3' => $apuestaPolla->Caballo3,
                'monto3' => $apuestaPolla->Monto3,
                'usuario_caballo3' => $usuarioCaballo3 ? $usuarioCaballo3->user->name : null,
                'caballo4' => $apuestaPolla->Caballo4,
                'monto4' => $apuestaPolla->Monto4,
                'usuario_caballo4' => $usuarioCaballo4 ? $usuarioCaballo4->user->name : null,
                'caballo5' => $apuestaPolla->Caballo5,
                'monto5' => $apuestaPolla->Monto5,
                'usuario_caballo5' => $usuarioCaballo5 ? $usuarioCaballo5->user->name : null,
                'estado' => $apuestaPolla->Estado,
                // Otros campos de ApuestaPolla que desees
            ];
        }

        // Puedes devolver los datos o pasarlos a una vista según tus necesidades
        return view('Admin.ApuestasArmadas', ['apuestasCombinadas' => $apuestasCombinadas]);
    }

    private function getUsuarioPorNombre($nombreCaballo, $apuestaUsers)
    {
        return $apuestaUsers->first(function ($user) use ($nombreCaballo) {
            return $user->caballo_id == $nombreCaballo;
        });
    }
}
