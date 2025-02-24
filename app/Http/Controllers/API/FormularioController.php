<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Formulario;
use Illuminate\Http\Request;

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
        $formulario = new Formulario();

        $formulario->inscrito           = $request->input('inscrito');
        $formulario->nombre_completo    = $request->input('nombre_completo');
        $formulario->fecha_nacimiento   = $request->input('fecha_nacimiento');
        $formulario->edad               = $request->input('edad');
        $formulario->telefono           = $request->input('telefono');
        $formulario->direccion          = $request->input('direccion');
        $formulario->correo             = $request->input('correo');
        $formulario->medicamentos       = $request->input('medicamentos');
        $formulario->enfermedades       = $request->input('enfermedades');
        $formulario->referencia         = $request->input('referencia');
        $formulario->entrenamiento      = $request->input('entrenamiento');
        $formulario->horario            = $request->input('horario');
        $formulario->dias_semana        = $request->input('dias_semana');
        $formulario->nivelEntrenamiento = $request->input('nivelEntrenamiento');
        $formulario->lesion             = $request->input('lesion');
        $formulario->objetivos          = $request->input('objetivos');
        $formulario->deportes_detalles  = $request->input('deportes_detalles');
        $formulario->usu_id             = $request->input('usu_id');

        $formulario->save();

        return response()->json([
            'success' => true,
            'message' => 'Formulario guardado exitosamente',
        ], 201);
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
