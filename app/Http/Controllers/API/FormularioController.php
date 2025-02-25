<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Formulario;
use App\Models\UsuarioLogin;
use App\Models\Usuarios;
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
        // Ningun campo vacio
        if (empty($request->input('inscrito')) ||
            empty($request->input('nombre_completo')) ||
            empty($request->input('fecha_nacimiento')) ||
            empty($request->input('edad')) ||
            empty($request->input('telefono')) ||
            empty($request->input('direccion')) ||
            empty($request->input('correo')) ||
            empty($request->input('medicamentos')) ||
            empty($request->input('enfermedades')) ||
            empty($request->input('referencia')) ||
            empty($request->input('entrenamiento')) ||
            empty($request->input('horario')) ||
            empty($request->input('dias_semana')) ||
            empty($request->input('nivel_entrenamiento')) ||
            empty($request->input('lesion')) ||
            empty($request->input('objetivos')) ||
            empty($request->input('deportes_detalles')) ||
            empty($request->input('usu_id'))) {
            return response()->json([
                'success' => false,
                'message' => 'Todos los campos son obligatorios',
            ], 400);
        }

        $formulario = new Formulario();

        $formulario->inscrito            = $request->input('inscrito');
        $formulario->nombre_completo     = $request->input('nombre_completo');
        $formulario->fecha_nacimiento    = $request->input('fecha_nacimiento');
        $formulario->edad                = $request->input('edad');
        $formulario->telefono            = $request->input('telefono');
        $formulario->direccion           = $request->input('direccion');
        $formulario->correo              = $request->input('correo');
        $formulario->medicamentos        = $request->input('medicamentos');
        $formulario->enfermedades        = $request->input('enfermedades');
        $formulario->referencia          = $request->input('referencia');
        $formulario->entrenamiento       = $request->input('entrenamiento');
        $formulario->horario             = $request->input('horario');
        $formulario->dias_semana         = $request->input('dias_semana');
        $formulario->nivel_entrenamiento = $request->input('nivel_entrenamiento');
        $formulario->lesion              = $request->input('lesion');
        $formulario->objetivos           = $request->input('objetivos');
        $formulario->deportes_detalles   = $request->input('deportes_detalles');
        $formulario->usu_id              = $request->input('usu_id');

        $user = UsuarioLogin::where('usu_id', $request->usu_id)->first();
        // $user->formulario = true;
        $user->usu_login_name = $request->nombre_completo;
        if ($request->correo && ! $user->usu_login_email) {
            $user->usu_login_email = $request->correo;
        }
        $user->save();
        $formulario->save();

        // $user                = Usuarios::where('usu_id', $request->usu_id)->first();
        // $user->usu_nombre    = $request->nombres;
        // $user->usu_apellidos = $request->apellidos;
        // $user->usu_edad      = $request->edad;
        // $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Formulario registrado con éxito',
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
