<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Rutinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RutinasController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $rutina = Rutinas::findOrFail($id);
        $rutina->rut_repeticiones = $request->rut_repeticiones ?? $rutina->rut_repeticiones;
        $rutina->rut_peso = $request->rut_peso ? ($request->rut_peso == 0 ? null : $request->rut_peso) : $rutina->rut_peso;
        $rutina->save();

        if (isset($request->rut_tiempo)) {
            $res = Rutinas::where('usu_id', $rutina->usu_id)->where('rut_dia', $rutina->rut_dia)->where('ejer_id', $rutina->ejer_id)->get();
            foreach ($res as $re) {
                $re->rut_tiempo = $request->rut_tiempo;
                $re->save();
            }
        }
        return response()->json($rutina);
    }

    public function destroy(string $id)
    {
        //
    }

    public function rutinasUser($id)
    {
        $rutinas = DB::table('rutinas as r')
            ->join('ejercicios as e', 'r.ejer_id', '=', 'e.ejer_id')
            ->join('equipos as eq', 'e.equi_id', '=', 'eq.equi_id')
            ->join('musculo as m', 'e.mus_id', '=', 'm.mus_id')
            ->where('r.rut_estado', 'ACTIVO')
            ->where('r.usu_id', $id)
            ->orderBy('r.rut_id', 'ASC')
            ->get();

        if (count($rutinas) > 0) {
            return response()->json($rutinas);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No hay rutinas registradas'
            ], 404);
        }
    }

    public function rutinasUserDia($id)
    {
        $rutinas = DB::table('rutinas as r')
            ->join('ejercicios as e', 'r.ejer_id', '=', 'e.ejer_id')
            ->join('equipos as eq', 'e.equi_id', '=', 'eq.equi_id')
            ->join('musculo as m', 'e.mus_id', '=', 'm.mus_id')
            ->where('r.rut_estado', 'ACTIVO')
            ->where('r.usu_id', $id)
            ->where('r.rut_dia', date('N'))
            ->orderBy('r.rut_id', 'ASC')
            ->get();

        if (count($rutinas) > 0) {
            return response()->json($rutinas);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No hay rutinas registradas'
            ], 404);
        }
    }
}
