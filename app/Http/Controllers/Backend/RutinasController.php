<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Ejercicios;
use App\Models\Rutinas;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RutinasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('rutina.view')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a ver ningún rutina!');
        }

        $rutinas = Rutinas::all();
        return view('backend.pages.rutinas.index', compact('rutinas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('rutina.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún rutina!');
        }

        $clientes = Usuarios::where('usu_estado', 'ACTIVO')->get();
        $ejercicios = Ejercicios::where('ejer_estado', 'ACTIVO')->get();
        return view('backend.pages.rutinas.create', compact('clientes', 'ejercicios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('rutina.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ninguna rutina!');
        }
        // dd($request);
        // die();
        $request->validate([
            'usu_id' => 'required',
            'ejer_id' => 'required',
            'dia' => 'required',
            'date_ini' => 'required',
            'date_fin' => 'required',
        ]);

        $newRutina = new Rutinas();
        $newRutina->usu_id = $request->usu_id;
        $newRutina->ejer_id = $request->ejer_id;
        $newRutina->rut_serie = $request->serie == null ? 0 : $request->serie;
        $newRutina->rut_repeticiones = $request->repeticiones == null ? 0 : $request->repeticiones;
        $newRutina->rut_peso = $request->peso == null ? 0 : $request->peso;
        $newRutina->rut_rid = $request->rid == null ? 0 : $request->rid;
        $newRutina->rut_tiempo = $request->tiempo == null ? 0 : $request->tiempo;
        $newRutina->rut_dia = $request->dia;
        $newRutina->rut_date_ini = $request->date_ini;
        $newRutina->rut_date_fin = $request->date_fin;
        $newRutina->save();

        session()->flash('success', '¡¡Se ha creado la rutina!!');
        return redirect()->route('admin.rutinas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        if (is_null($this->user) || !$this->user->can('rutina.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ninguna rutina!');
        }

        $rutina = Rutinas::find($id);
        $clientes = Usuarios::where('usu_estado', 'ACTIVO')->get();
        $ejercicios = Ejercicios::where('ejer_estado', 'ACTIVO')->get();
        return view('backend.pages.rutinas.edit', compact('rutina', 'clientes', 'ejercicios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        if (is_null($this->user) || !$this->user->can('rutina.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún rutina!');
        }

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin rutinae,
        // so that no-one could delete or disable it by somehow.
        if ($id === 1) {
            session()->flash('error', 'Lo siento !! ¡No estás autorizado a editar este rutina!');
            return back();
        }
        $request->validate([
            'usu_id' => 'required',
            'ejer_id' => 'required',
            'dia' => 'required',
            'date_ini' => 'required',
            'date_fin' => 'required',
        ]);

        $editRutina = Rutinas::find($id);
        $editRutina->usu_id = $request->usu_id;
        $editRutina->ejer_id = $request->ejer_id;
        $editRutina->rut_serie = $request->serie == null ? 0 : $request->serie;
        $editRutina->rut_repeticiones = $request->repeticiones == null ? 0 : $request->repeticiones;
        $editRutina->rut_peso = $request->peso == null ? 0 : $request->peso;
        $editRutina->rut_rid = $request->rid == null ? 0 : $request->rid;
        $editRutina->rut_tiempo = $request->tiempo == null ? 0 : $request->tiempo;
        $editRutina->rut_dia = $request->dia;
        $editRutina->rut_date_ini = $request->date_ini;
        $editRutina->rut_date_fin = $request->date_fin;
        $editRutina->save();

        session()->flash('success', '¡¡La rutina ha sido actualizada!!');
        return redirect()->route('admin.rutinas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('rutina.delete')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a eliminar ningún rutina!');
        }

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin rutinae,
        // so that no-one could delete or disable it by somehow.
        // if ($id === 1) {
        //     session()->flash('error', 'Lo siento !! ¡No estás autorizado a eliminar este rutina!');
        //     return back();
        // }

        $rutina = Rutinas::find($id);
        if (!is_null($rutina)) {
            $rutina->delete();
        }

        session()->flash('success', '¡¡La rutina ha sido eliminada!!');
        return back();
    }
}
