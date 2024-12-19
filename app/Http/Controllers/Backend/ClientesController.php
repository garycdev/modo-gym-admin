<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientesController extends Controller
{
    public $user;
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function index()
    {
        $clientes = Usuarios::where('usu_estado', '<>', 'ELIMINADO')->orderBy('usu_id', 'DESC')->get();
        return view('backend.pages.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('cliente.view')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún usuario!');
        }
        // dd($request);
        // die();
        $request->validate([
            'nombre' => 'required',
            'edad' => 'required|numeric',
            'huella' => 'required|numeric',
            // 'ci' => 'required|numeric|unique:usuarios,usu_ci',
            'ci' => 'required|numeric',
            'celular' => 'nullable|numeric',
            'genero' => 'required',
            'nivel' => 'required',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'frecuencia' => 'nullable|numeric',
            'hora' => 'nullable|numeric',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'edad.required' => 'La edad es requerida',
            'edad.numeric' => 'La edad debe ser numérica',
            'huella.required' => 'La huella es requerida',
            'ci.required' => 'El CI es obligatorio',
            'ci.unique' => 'El CI ya existe',
            'celular.numeric' => 'El numero telefónico debe ser valido',
            'genero.required' => 'El genero es obligatorio',
            'nivel.required' => 'El nivel es obligatorio',
        ]);

        $newCliente = new Usuarios();
        $newCliente->usu_nombre = $request->nombre;
        $newCliente->usu_apellidos = $request->apellidos;
        $newCliente->usu_ci = $request->ci;
        $newCliente->usu_celular = $request->celular;
        $newCliente->usu_huella = $request->huella;
        $newCliente->usu_edad = $request->edad;
        $newCliente->usu_genero = $request->genero;
        $newCliente->usu_nivel = $request->nivel;
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('image/cliente');
            $image->move($imagePath, $imageName);
            $newCliente->usu_imagen = 'image/cliente' . '/' . $imageName;
        }
        $newCliente->usu_frecuencia = $request->frecuencia;
        $newCliente->usu_hora = $request->hora;
        $newCliente->usu_ante_medicos = $request->ante_medicos;
        $newCliente->usu_lesiones = $request->lesiones;
        $newCliente->usu_objetivo = $request->objetivo;
        $newCliente->usu_deportes = $request->deportes;
        $newCliente->save();

        session()->flash('success', '¡¡Se ha creado el usuario!!');
        return redirect()->route('admin.clientes.index');
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
        if (is_null($this->user) || !$this->user->can('cliente.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún usuario!');
        }

        $cliente = Usuarios::find($id);
        return view('backend.pages.clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (is_null($this->user) || !$this->user->can('cliente.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún usuario!');
        }
        $request->validate([
            'ci' => 'required|numeric',
            'celular' => 'nullable|numeric',
            'nombre' => 'required',
            'edad' => 'required|numeric',
            'huella' => 'required|numeric',
            'genero' => 'required',
            'nivel' => 'required',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'frecuencia' => 'nullable|numeric',
            'hora' => 'nullable|numeric',
            'estado' => 'required',
        ]);

        $editCliente = Usuarios::find($id);
        $editCliente->usu_nombre = $request->nombre;
        $editCliente->usu_apellidos = $request->apellidos;
        $editCliente->usu_ci = $request->ci;
        $editCliente->usu_celular = $request->celular;
        $editCliente->usu_huella = $request->huella;
        $editCliente->usu_edad = $request->edad;
        $editCliente->usu_genero = $request->genero;
        $editCliente->usu_nivel = $request->nivel;
        if ($request->hasFile('imagen')) {
            if ($editCliente->usu_imagen && file_exists(public_path($editCliente->usu_imagen))) {
                unlink(public_path($editCliente->usu_imagen));
            }
            $image = $request->file('imagen');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('image/cliente');
            $image->move($imagePath, $imageName);
            $editCliente->usu_imagen = 'image/cliente' . '/' . $imageName;
        }
        $editCliente->usu_frecuencia = $request->frecuencia;
        $editCliente->usu_hora = $request->hora;
        $editCliente->usu_ante_medicos = $request->ante_medicos;
        $editCliente->usu_lesiones = $request->lesiones;
        $editCliente->usu_objetivo = $request->objetivo;
        $editCliente->usu_deportes = $request->deportes;
        $editCliente->usu_estado = $request->estado;
        $editCliente->save();

        session()->flash('success', '¡¡Se ha modificado el usuario!!');
        return redirect()->route('admin.clientes.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (is_null($this->user) || !$this->user->can('cliente.delete')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a eliminar ningún equipo!');
        }
        if ($id === 1) {
            session()->flash('error', 'Lo siento !! ¡No estás autorizado a eliminar este usuario!');
            return back();
        }

        $cliente = Usuarios::find($id);
        // Eliminar la imagen existente
        if ($cliente->usu_imagen && file_exists(public_path($cliente->usu_imagen))) {
            unlink(public_path($cliente->usu_imagen));
        }
        $cliente->usu_estado = 'ELIMINADO';
        // Guardar los cambios en la base de datos
        $cliente->save();

        session()->flash('success', '¡¡El usuario ha sido eliminado!!');
        return back();
    }
}
