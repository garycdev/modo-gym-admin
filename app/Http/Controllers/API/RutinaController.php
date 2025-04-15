<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Grupo;
use App\Models\Rutina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RutinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $grupos = Grupo::where('usu_login_id', $request->user()->usu_login_id)->get();

        foreach ($grupos as $key => $rut) {
            $rutinas = DB::table('rutina as r')
                ->join('ejercicios as e', 'r.ejer_id', '=', 'e.ejer_id')
                ->join('equipos as eq', 'e.equi_id', '=', 'eq.equi_id')
                ->join('musculo as m', 'e.mus_id', '=', 'm.mus_id')
                ->where('r.rut_estado', 'ACTIVO')
                ->where('r.rut_estado', '<>', 'COMPLETADO')
                ->where('r.rut_grupo', $rut->id)
                ->orderBy('r.ejer_id', 'ASC')
                ->orderBy('r.rut_id', 'ASC')
                ->get();

            $grupos[$key]['ejercicios'] = $rutinas;
        }

        if (count($grupos) > 0) {
            return response()->json([
                'success' => true,
                'message' => 'Grupo del usuario',
                'data'    => $grupos->toArray(),
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No hay ejercicios registrados',
                'data'    => [],
            ], 404);
        }
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
        if ($request->rut_id) {
            $rutina = Rutina::where('rut_id', $request->rut_id)->first();
            if (! $rutina) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ejercicio no encontrado',
                ], 404);
            }

            $serie             = new Rutina();
            $serie->ejer_id    = $rutina->ejer_id;
            $serie->rut_grupo  = $rutina->rut_grupo;
            $serie->rut_serie  = $rutina->rut_serie + 1;
            $serie->rut_tiempo = $rutina->rut_tiempo;
            $serie->save();

            return response()->json([
                'success' => true,
                'message' => 'Serie de ejercicio creada correctamente',
                'data'    => $serie,
            ], 200);
        }

        $rut = $request->toArray();
        if (isset($rut['grupo'])) {
            $grupo = Grupo::where('id', $request->grupo)->first();
        } else {
            $grupo               = new Grupo();
            $grupo->titulo       = $rut['rut_titulo'];
            $grupo->estado       = 'ACTIVO';
            $grupo->usu_login_id = $request->user()->usu_login_id;
            $grupo->save();
        }

        foreach ($rut['rutinas'] as $ejer) {
            foreach ($ejer['rut_series'] as $ser) {
                $new                   = new Rutina();
                $new->ejer_id          = $ejer['ejer_id'];
                $new->rut_grupo        = $grupo->id;
                $new->rut_serie        = $ser['serie'];
                $new->rut_repeticiones = $ser['reps'];
                $new->rut_peso         = $ser['peso'];
                $new->rut_rid          = $ser['rir'];
                $new->rut_tiempo       = $ejer['rut_tiempo'];
                $new->rut_estado       = 'ACTIVO';
                $new->estado           = $ser['activo'];
                $new->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Rutina creada correctamente',
            'data'    => $grupo,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rutinas = DB::table('rutina as r')
            ->join('ejercicios as e', 'r.ejer_id', '=', 'e.ejer_id')
            ->join('equipos as eq', 'e.equi_id', '=', 'eq.equi_id')
            ->join('musculo as m', 'e.mus_id', '=', 'm.mus_id')
            ->join('rgrupo as g', 'g.id', '=', 'r.rut_grupo')
            ->where('r.rut_estado', 'ACTIVO')
            ->where('r.rut_estado', '<>', 'COMPLETADO')
            ->where('r.rut_grupo', $id)
            ->orderBy('r.ejer_id', 'ASC')
            ->orderBy('r.rut_id', 'ASC')
            ->select('r.*', 'e.*', 'eq.*', 'm.*', 'g.titulo', 'g.estado as grupo_estado')
            ->get();

        if (count($rutinas) > 0) {
            return response()->json([
                'success' => true,
                'message' => 'Grupo del usuario',
                'data'    => $rutinas->toArray(),
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No hay ejercicios registrados',
                'data'    => [],
            ], 404);
        }
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
        if (isset($request->titulo)) {
            $grupo = Grupo::where('id', $id)->first();
            if (! $grupo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Grupo no encontrado',
                ], 404);
            }

            $grupo->titulo = $request->titulo;
            $grupo->save();

            return response()->json([
                'success' => true,
                'message' => 'Grupo modificado correctamente',
                'data'    => $grupo,
            ], 200);
        }

        $rutina = Rutina::where('rut_id', $id)->first();

        if (! $rutina) {
            return response()->json([
                'success' => false,
                'message' => 'Ejercicio no encontrado',
            ], 404);
        }

        if (isset($request->ejer_id)) {
            Rutina::where('ejer_id', $rutina->ejer_id)->where('rut_grupo', $rutina->rut_grupo)->update(['ejer_id' => $request->ejer_id]);

            return response()->json([
                'success' => true,
                'message' => 'Ejercicio reemplazado',
            ], 200);
        }

        $rutina->rut_repeticiones = $request->rut_repeticiones ?? $rutina->rut_repeticiones;
        $rutina->rut_peso         = $request->rut_peso ?? $rutina->rut_peso;
        $rutina->rut_rid          = $request->rut_rid ?? $rutina->rut_rid;
        if (isset($request->estado)) {
            if ($request->estado == 'true') {
                $rutina->estado = 1;
            } else if ($request->estado == 'false') {
                $rutina->estado = 0;
            }
        }
        $rutina->save();

        if (isset($request->rut_tiempo)) {
            $res = Rutina::where('rut_grupo', $rutina->rut_grupo)->where('ejer_id', $rutina->ejer_id)->get();
            foreach ($res as $re) {
                $re->rut_tiempo = $request->rut_tiempo;
                $re->save();
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Ejercicio actualizado correctamente',
            'data'    => $rutina,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grupo = Grupo::where('id', $id)->first();

        if (! $grupo) {
            return response()->json([
                'success' => false,
                'message' => 'La rutina no existe',
            ], 404);
        }

        Rutina::where('rut_grupo', $grupo->id)->delete();
        $grupo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rutina eliminada correctamente',
        ], 200);
    }
    public function destroyRutina(string $id)
    {
        $rutina = Rutina::where('rut_id', $id)->first();
        if (! $rutina) {
            return response()->json([
                'success' => false,
                'message' => 'La rutina no existe',
            ], 404);
        }
        $grupo = $rutina->rut_grupo;

        $rutina->delete();

        $rutinas = Rutina::where('rut_grupo', $grupo)->get();
        if ($rutinas->isEmpty()) {
            Grupo::where('id', $grupo)->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Serie eliminada correctamente',
            'data'    => [],
        ], 200);
    }
    public function destroyEjercicio(string $id)
    {
        $rutina = Rutina::where('rut_id', $id)->first();
        if (! $rutina) {
            return response()->json([
                'success' => false,
                'message' => 'La rutina no existe',
            ], 404);
        }

        Rutina::where('rut_grupo', $rutina->rut_grupo)->where('ejer_id', $rutina->ejer_id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ejercicio eliminado correctamente',
            'data'    => [],
        ], 200);
    }
}
