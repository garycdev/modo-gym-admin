<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Defecto;
use App\Models\Ejercicios;
use App\Models\RutinaDefecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DefectoController extends Controller
{
    public $user;
    public $guard;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $guards = ['admin', 'user'];

            foreach ($guards as $guard) {
                if (Auth::guard($guard)->check()) {
                    $this->user = Auth::guard($guard)->user();
                    $this->guard = $guard;
                    break;
                }
            }
            return $next($request);
        });
    }

    public function index()
    {
        if (is_null($this->user) || !$this->user->can('rutina.view')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a ver ningún rutina!');
        }

        $defecto = Defecto::where('def_estado', '<>', 'ELIMINADO')->get();

        return view('backend.pages.rutinas.defecto.index', compact('defecto'));
    }

    public function show(int $id)
    {
        if (is_null($this->user) || !$this->user->can('rutina.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ninguna rutina!');
        }
        $defecto = Defecto::find($id);

        $lunes = RutinaDefecto::from('rutinas_defecto as rd')
            ->join('ejercicios as ejer', 'ejer.ejer_id', '=', 'rd.ejer_id')
            ->where('rd.rut_dia', 1)
            ->where('rd.rut_estado', 'ACTIVO')
            ->where('rd.def_id', $id)
            ->groupBy('rd.ejer_id')
            ->orderBy('ejer.ejer_nivel', 'DESC')
            ->orderBy('rd.rut_serie', 'ASC')
            ->get();
        $dias[1] = RutinaDefecto::from('rutinas_defecto as rd')
            ->join('ejercicios as ejer', 'ejer.ejer_id', '=', 'rd.ejer_id')
            ->where('rd.rut_dia', 1)
            ->where('rd.rut_estado', 'ACTIVO')
            ->where('rd.def_id', $id)
            ->orderBy('ejer.ejer_nivel', 'DESC')
            ->orderBy('rd.rut_serie', 'ASC')
            ->get();
        $martes = RutinaDefecto::from('rutinas_defecto as rd')
            ->join('ejercicios as ejer', 'ejer.ejer_id', '=', 'rd.ejer_id')
            ->where('rd.rut_dia', 2)
            ->where('rd.rut_estado', 'ACTIVO')
            ->where('rd.def_id', $id)
            ->groupBy('rd.ejer_id')
            ->orderBy('ejer.ejer_nivel', 'DESC')
            ->orderBy('rd.rut_serie', 'ASC')
            ->get();
        $dias[2] = RutinaDefecto::from('rutinas_defecto as rd')
            ->join('ejercicios as ejer', 'ejer.ejer_id', '=', 'rd.ejer_id')
            ->where('rd.rut_dia', 2)
            ->where('rd.rut_estado', 'ACTIVO')
            ->where('rd.def_id', $id)
            ->orderBy('ejer.ejer_nivel', 'DESC')
            ->orderBy('rd.rut_serie', 'ASC')
            ->get();
        $miercoles = RutinaDefecto::from('rutinas_defecto as rd')
            ->join('ejercicios as ejer', 'ejer.ejer_id', '=', 'rd.ejer_id')
            ->where('rd.rut_dia', 3)
            ->where('rd.rut_estado', 'ACTIVO')
            ->where('rd.def_id', $id)
            ->groupBy('rd.ejer_id')
            ->orderBy('ejer.ejer_nivel', 'DESC')
            ->orderBy('rd.rut_serie', 'ASC')
            ->get();
        $dias[3] = RutinaDefecto::from('rutinas_defecto as rd')
            ->join('ejercicios as ejer', 'ejer.ejer_id', '=', 'rd.ejer_id')
            ->where('rd.rut_dia', 3)
            ->where('rd.rut_estado', 'ACTIVO')
            ->where('rd.def_id', $id)
            ->orderBy('ejer.ejer_nivel', 'DESC')
            ->orderBy('rd.rut_serie', 'ASC')
            ->get();
        $jueves = RutinaDefecto::from('rutinas_defecto as rd')
            ->join('ejercicios as ejer', 'ejer.ejer_id', '=', 'rd.ejer_id')
            ->where('rd.rut_dia', 4)
            ->where('rd.rut_estado', 'ACTIVO')
            ->where('rd.def_id', $id)
            ->groupBy('rd.ejer_id')
            ->orderBy('ejer.ejer_nivel', 'DESC')
            ->orderBy('rd.rut_serie', 'ASC')
            ->get();
        $dias[4] = RutinaDefecto::from('rutinas_defecto as rd')
            ->join('ejercicios as ejer', 'ejer.ejer_id', '=', 'rd.ejer_id')
            ->where('rd.rut_dia', 4)
            ->where('rd.rut_estado', 'ACTIVO')
            ->where('rd.def_id', $id)
            ->orderBy('ejer.ejer_nivel', 'DESC')
            ->orderBy('rd.rut_serie', 'ASC')
            ->get();
        $viernes = RutinaDefecto::from('rutinas_defecto as rd')
            ->join('ejercicios as ejer', 'ejer.ejer_id', '=', 'rd.ejer_id')
            ->where('rd.rut_dia', 5)
            ->where('rd.rut_estado', 'ACTIVO')
            ->where('rd.def_id', $id)
            ->groupBy('rd.ejer_id')
            ->orderBy('ejer.ejer_nivel', 'DESC')
            ->orderBy('rd.rut_serie', 'ASC')
            ->get();
        $dias[5] = RutinaDefecto::from('rutinas_defecto as rd')
            ->join('ejercicios as ejer', 'ejer.ejer_id', '=', 'rd.ejer_id')
            ->where('rd.rut_dia', 5)
            ->where('rd.rut_estado', 'ACTIVO')
            ->where('rd.def_id', $id)
            ->orderBy('ejer.ejer_nivel', 'DESC')
            ->orderBy('rd.rut_serie', 'ASC')
            ->get();
        $sabado = RutinaDefecto::from('rutinas_defecto as rd')
            ->join('ejercicios as ejer', 'ejer.ejer_id', '=', 'rd.ejer_id')
            ->where('rd.rut_dia', 6)
            ->where('rd.rut_estado', 'ACTIVO')
            ->where('rd.def_id', $id)
            ->groupBy('rd.ejer_id')
            ->orderBy('ejer.ejer_nivel', 'DESC')
            ->orderBy('rd.rut_serie', 'ASC')
            ->get();
        $dias[6] = RutinaDefecto::from('rutinas_defecto as rd')
            ->join('ejercicios as ejer', 'ejer.ejer_id', '=', 'rd.ejer_id')
            ->where('rd.rut_dia', 6)
            ->where('rd.rut_estado', 'ACTIVO')
            ->where('rd.def_id', $id)
            ->orderBy('ejer.ejer_nivel', 'DESC')
            ->orderBy('rd.rut_serie', 'ASC')
            ->get();
        $domingo = RutinaDefecto::from('rutinas_defecto as rd')
            ->join('ejercicios as ejer', 'ejer.ejer_id', '=', 'rd.ejer_id')
            ->where('rd.rut_dia', 7)
            ->where('rd.rut_estado', 'ACTIVO')
            ->where('rd.def_id', $id)
            ->groupBy('rd.ejer_id')
            ->orderBy('ejer.ejer_nivel', 'DESC')
            ->orderBy('rd.rut_serie', 'ASC')
            ->get();
        $dias[7] = RutinaDefecto::from('rutinas_defecto as rd')
            ->join('ejercicios as ejer', 'ejer.ejer_id', '=', 'rd.ejer_id')
            ->where('rd.rut_dia', 7)
            ->where('rd.rut_estado', 'ACTIVO')
            ->where('rd.def_id', $id)
            ->orderBy('ejer.ejer_nivel', 'DESC')
            ->orderBy('rd.rut_serie', 'ASC')
            ->get();

        $ejercicios = Ejercicios::select('ejercicios.*', 'equipos.*', 'musculo.*')
            ->join('equipos', 'ejercicios.equi_id', '=', 'equipos.equi_id')
            ->join('musculo', 'ejercicios.mus_id', '=', 'musculo.mus_id')
            ->where('ejercicios.ejer_estado', '!=', 'ELIMINADO')
            ->where('equipos.equi_estado', '!=', 'ELIMINADO')
            ->where('musculo.mus_estado', '!=', 'ELIMINADO')
            ->get();

        return view('backend.pages.rutinas.defecto.rutinas-def', compact('defecto', 'ejercicios', 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo', 'dias'));
    }

    public function create()
    {
        if (is_null($this->user) || !$this->user->can('rutina.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún rutina!');
        }

        return view('backend.pages.rutinas.defecto.create');
    }

    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('rutina.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ninguna rutina!');
        }
        $request->validate([
            'def_nombre' => 'required',
        ]);

        $defecto = new Defecto();
        $defecto->def_nombre = $request->def_nombre;
        $defecto->save();

        session()->flash('success', '¡¡Se han creado la rutina por defecto!!');
        return redirect()->route('admin.defecto.index');
    }

    public function edit(int $id)
    {
        if (is_null($this->user) || !$this->user->can('rutina.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ninguna rutina!');
        }

        $defecto = Defecto::find($id);
        return view('backend.pages.rutinas.defecto.edit', compact('defecto'));
    }

    public function update(Request $request, int $id)
    {
        if (is_null($this->user) || !$this->user->can('rutina.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún rutina!');
        }

        $request->validate([
            'def_nombre' => 'required',
        ]);

        $defecto = Defecto::find($id);
        $defecto->def_nombre = $request->def_nombre;
        $defecto->def_estado = $request->def_estado;
        $defecto->save();

        session()->flash('success', '¡¡ La rutina por defecto ha sido modificada!!');
        return redirect()->route('admin.defecto.index');
    }




    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('rutina.delete')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a eliminar ningún rutina!');
        }

        $rutina = Defecto::find($id);
        if (!is_null($rutina)) {
            $rutina->def_estado = 'ELIMINADO';
            $rutina->save();
        }

        session()->flash('success', '¡¡La rutina ha sido eliminada!!');
        return back();
    }
}
