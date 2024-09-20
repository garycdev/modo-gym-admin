<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Formulario;
use App\Models\UsuarioLogin;

class FormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'inscrito' => 'required|string',
            'nombre_completo' => 'required|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'edad' => 'nullable|integer|min:10',
            'telefono' => 'nullable|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'correo' => 'nullable|email|max:255',
            'medicamentos' => 'nullable|string',
            'enfermedades' => 'nullable|string',
            'referencia' => 'nullable|string',
            'entrenamiento' => 'nullable|string',
            'horario' => 'nullable|string',
            'dias_semana' => 'nullable|string',
            'nivel_entrenamiento' => 'nullable|string',
            'lesion' => 'nullable|string',
            'objetivos' => 'nullable|array', // Debe ser un array
            'deportes_detalles' => 'nullable|string',
            'usu_id' => 'required|exists:usuarios,usu_id' // Validamos que el usuario exista
        ]);

        // Crear el nuevo objeto Formulario
        $formulario = new Formulario();

        // Asignar valores al objeto Formulario
        $formulario->inscrito = $request->inscrito;
        $formulario->nombre_completo = $request->nombre_completo;
        $formulario->fecha_nacimiento = $request->fecha_nacimiento;
        $formulario->edad = $request->edad;
        $formulario->telefono = $request->telefono;
        $formulario->direccion = $request->direccion;
        $formulario->correo = $request->correo;
        $formulario->medicamentos = $request->medicamentos;
        $formulario->enfermedades = $request->enfermedades;
        $formulario->referencia = $request->referencia;
        $formulario->entrenamiento = $request->entrenamiento;
        $formulario->horario = $request->horario;
        $formulario->dias_semana = $request->dias_semana;
        $formulario->nivel_entrenamiento = $request->nivel_entrenamiento;
        $formulario->lesion = $request->lesion;
        $formulario->objetivos = $request->objetivos;
        $formulario->deportes_detalles = $request->deportes_detalles;
        $formulario->usu_id = $request->usu_id;

        // Guardar el formulario en la base de datos
        $formulario->save();

        $user = UsuarioLogin::where('usu_id', $request->usu_id)->first();
        $user->formulario = true;
        $user->save();

        // Redirigir con un mensaje de éxito
        return back()->with('success', 'Formulario enviado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
