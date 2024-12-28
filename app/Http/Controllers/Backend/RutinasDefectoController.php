<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ejercicios;
use App\Models\RutinaDefecto;

class RutinasDefectoController extends Controller
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

        $rutinas = RutinaDefecto::where('rut_estado', '<>', 'ELIMINADO')->get();

        return view('backend.pages.rutinas.rutinas-def-list', compact('rutinas'));
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

        // dd($request);
        // die();
        // return response()->json($request);
        $request->validate([
            'def_id' => 'required',
        ]);

        foreach ($request->rutinas as $rut) {
            $newRutina = new RutinaDefecto();
            $newRutina->def_id = $request->def_id;
            $newRutina->ejer_id = $rut;
            $newRutina->rut_serie = 0;
            $newRutina->rut_repeticiones = 0;
            // $newRutina->rut_peso = 0;
            $newRutina->rut_rid = 0;
            // $newRutina->rut_tiempo = 0;
            $newRutina->rut_dia = $request->dia;
            // $newRutina->rut_date_ini = date('Y-m-d');
            // $newRutina->rut_date_fin = date('Y-m-d');
            $newRutina->save();
        }

        return true;
    }

    public function guardarRutina(Request $request)
    {
        if ($request->id) {
            if ($request->tiempo) {
                $rutinas = RutinaDefecto::where('def_id', $request->def_id)
                    ->where('ejer_id', $request->ejer_id)
                    ->where('rut_dia', $request->dia)
                    ->get();
                foreach ($rutinas as $rutina) {
                    $rutina->rut_tiempo = $request->tiempo;
                    $rutina->save();
                }
            } else {
                $rutina = RutinaDefecto::where('rd_id', $request->id)->first();
                $rutina->rut_serie = $request->serie;
                $rutina->rut_peso = $request->peso ?? 0;
                $rutina->rut_rid = $request->rir ?? 0;
                $rutina->rut_repeticiones = $request->repeticiones ?? 1;
                $rutina->save();
            }
        } else {
            $rutina = new RutinaDefecto();
            $rutina->def_id = $request->def_id;
            $rutina->ejer_id = $request->ejer_id;
            $rutina->rut_serie = intval($request->serie) + 1;
            $rutina->rut_repeticiones = 1;
            $rutina->rut_peso = 0;
            $rutina->rut_rid = 0;
            $rutina->rut_tiempo = 0;
            $rutina->rut_dia = $request->dia;
            $rutina->save();
        }

        return $rutina;
    }
    public function eliminarRutina(Request $request)
    {
        $rutina = RutinaDefecto::where('rd_id', $request->id)->first();
        $rutina->delete();

        return $rutina;
    }
}
