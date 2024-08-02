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

        if ($this->guard == 'user') {
            $rutinas = Rutinas::where('usu_id', Auth::guard('user')->user()->usu_id)
                ->orderBy('rut_grupo', 'DESC')
                ->orderBy('usu_id', 'ASC')
                ->orderBy('rut_dia', 'ASC')
                ->get();
        } else {
            $rutinas = Rutinas::orderBy('rut_grupo', 'DESC')
                ->orderBy('usu_id', 'ASC')
                ->orderBy('rut_dia', 'ASC')
                ->get();
        }
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

        $clientes = Usuarios::select('usuarios.*', 'pagos.pago_fecha', 'costos.mes')
            ->join('pagos', 'usuarios.usu_id', '=', 'pagos.usu_id')
            ->join('costos', 'pagos.costo_id', '=', 'costos.costo_id')
            ->whereRaw('pagos.pago_fecha >= DATE_SUB(CURDATE(), INTERVAL (costos.mes * 30) DAY)')
            ->where('usuarios.usu_estado', 'ACTIVO')
            ->orderBy('usuarios.usu_id', 'DESC')
            ->get();
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
            'rut_dia' => 'required',
            'fecha_ini' => 'required',
            'fecha_fin' => 'required',
        ]);

        if (isset($request->anterior)) {
            if ($request->anterior == 'on') {
                $rut_grupo = $request->id_anterior;
            }
        } else {
            $rut_grupo = $request->id_anterior + 1;
        }
        // Recorrer por dias lunes a domingo (1 - 7)
        // for ($dia = 1; $dia <= 7; $dia++) {
        //     // Recorrer por cantidad de rutinas por dia
        //     $rutinas_dia = intval($request->input('rut_' . $dia));
        //     for ($i = 0; $i <= $rutinas_dia; $i++) {
        //         if ($request->has('ejer_id-' . $dia . '_' . $i) && $request->has('serie-' . $dia . '_' . $i) && $request->has('repeticiones-' . $dia . '_' . $i)) {
        //             $newRutina = new Rutinas();
        //             $newRutina->usu_id = $request->usu_id;
        //             $newRutina->rut_grupo = $rut_grupo;
        //             $newRutina->ejer_id = $request->input('ejer_id-' . $dia . '_' . $i);
        //             $newRutina->rut_serie = $request->input('serie-' . $dia . '_' . $i);
        //             $newRutina->rut_repeticiones = $request->input('repeticiones-' . $dia . '_' . $i);
        //             $newRutina->rut_peso = $request->has('peso-' . $dia . '_' . $i) ? $request->input('peso-' . $dia . '_' . $i) : null;
        //             $newRutina->rut_rid = 0;
        //             $newRutina->rut_tiempo = 0;
        //             $newRutina->rut_dia = $dia;
        //             $newRutina->rut_date_ini = $request->fecha_ini;
        //             $newRutina->rut_date_fin = $request->fecha_fin;
        //             $newRutina->save();
        //         }
        //     }
        // }

        if (isset($request->id_ejer)) {
            foreach ($request->id_ejer as $key => $value) {
                foreach ($request->series[$key]['serie'] as $key2 => $value2) {
                    $newRutina = new Rutinas();
                    $newRutina->usu_id = $request->usu_id;
                    $newRutina->rut_grupo = $rut_grupo;
                    $newRutina->ejer_id = $value[0];
                    $newRutina->rut_serie = $value2;
                    if (isset($request->series[$key]['peso'][$key2])) {
                        $newRutina->rut_peso = $request->series[$key]['peso'][$key2];
                    }
                    if (isset($request->series[$key]['rep'][$key2])) {
                        $newRutina->rut_repeticiones = $request->series[$key]['rep'][$key2];
                    }
                    $newRutina->rut_rid = 0;
                    $newRutina->rut_tiempo = 0;
                    $newRutina->rut_dia = $request->rut_dia;
                    $newRutina->rut_date_ini = $request->fecha_ini;
                    $newRutina->rut_date_fin = $request->fecha_fin;
                    $newRutina->save();
                }
            }
        }

        session()->flash('success', '¡¡Se han creado las rutina!!');
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
        // if ($id === 1) {
        //     session()->flash('error', 'Lo siento !! ¡No estás autorizado a editar este rutina!');
        //     return back();
        // }
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

    public function user(Request $request)
    {
        return Rutinas::select('rut_grupo')->where('usu_id', $request->id)->groupBy('rut_grupo')->orderBy('rut_grupo', 'DESC')->first();
    }
}
