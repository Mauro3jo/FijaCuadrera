<?php

namespace App\Http\Controllers;

use App\Models\HistorialUser;
use App\Models\User;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $historiales = HistorialUser::all();
        return view('historiales.index', compact('historiales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all()->pluck('name', 'id'); // Obtiene todos los usuarios y los formatea para el <select>
        return view('historiales.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'semana' => 'required|string',
            'a_depositar' => 'nullable|numeric',
            'total_depositado' => 'nullable|numeric',
            'saldo' => 'nullable|numeric',
            'gano' => 'nullable|numeric',
            'perdio' => 'nullable|numeric',
            'comision' => 'nullable|numeric',
            'SALDO_NEGATIVO' => 'nullable|numeric',
            'SALDO_POSITIVO' => 'nullable|numeric',
            'SaldoAnterior' => 'nullable|numeric',
            'Diferencia' => 'nullable|numeric',
            'SaldoFinal' => 'nullable|numeric',
            'OBSERVACION' => 'nullable|string',
            'INICIO' => 'nullable|date',
            'FIN' => 'nullable|date',
            'user_id' => 'required|exists:users,id',
        ]);

        // Crear un nuevo historial con los datos validados
        $historial = HistorialUser::create($validatedData);

        // Redirigir al usuario a la lista de historiales con un mensaje de éxito
        return redirect()->route('historiales.index')->with('success', 'Historial creado con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  HistorialUser $historial
     * @return \Illuminate\Http\Response
     */
    public function show(HistorialUser $historial)
    {
        return view('historiales.show', compact('historial'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  HistorialUser $historial
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $historial = HistorialUser::findOrFail($id);
        $users = User::all()->pluck('name', 'id'); // Obtiene todos los usuarios para el <select>
        return view('historiales.edit', compact('historial', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  HistorialUser $historial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Encuentra el historial por ID
        $historial = HistorialUser::findOrFail($id);

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'semana' => 'required|string',
            'a_depositar' => 'nullable|numeric',
            'total_depositado' => 'nullable|numeric',
            'saldo' => 'nullable|numeric',
            'gano' => 'nullable|numeric',
            'perdio' => 'nullable|numeric',
            'comision' => 'nullable|numeric',
            'SALDO_NEGATIVO' => 'nullable|numeric',
            'SALDO_POSITIVO' => 'nullable|numeric',
            'SaldoAnterior' => 'nullable|numeric',
            'Diferencia' => 'nullable|numeric',
            'SaldoFinal' => 'nullable|numeric',
            'OBSERVACION' => 'nullable|string',
            'INICIO' => 'nullable|date',
            'FIN' => 'nullable|date',
            'user_id' => 'required|exists:users,id',
        ]);

        // Actualizar el historial con los datos validados
        $historial->update($validatedData);

        // Redirigir al usuario a la lista de historiales con un mensaje de éxito
        return redirect()->route('historiales.index')->with('success', 'Historial actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  HistorialUser $historial
     * @return \Illuminate\Http\Response
     */
    public function destroy(HistorialUser $historial)
    {
        $historial->delete();
        return redirect()->route('historiales.index')->with('success', 'Historial eliminado con éxito.');
    }
}
