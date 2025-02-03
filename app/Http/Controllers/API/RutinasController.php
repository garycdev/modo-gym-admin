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
        if (! $request->rut_id) {
            return response()->json([
                'success' => false,
                'message' => 'No se ha proporcionado un ID de ejercicio',
            ], 400);
        }

        $rutina = Rutinas::where('rut_id', $request->rut_id)->first();
        if (! $rutina) {
            return response()->json([
                'success' => false,
                'message' => 'Ejercicio no encontrado',
            ], 404);
        }

        $serie               = new Rutinas();
        $serie->usu_id       = $rutina->usu_id;
        $serie->rut_grupo    = 1;
        $serie->ejer_id      = $rutina->ejer_id;
        $serie->rut_serie    = $rutina->rut_serie + 1;
        $serie->rut_dia      = $rutina->rut_dia;
        $serie->rut_date_ini = date('Y-m-d');
        $serie->rut_date_fin = date('Y-m-d');
        $serie->save();

        return response()->json([
            'success' => true,
            'message' => 'Serie de ejercicio creada correctamente',
        ]);
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
        if (! $rutina) {
            return response()->json([
                'success' => false,
                'message' => 'Ejercicio no encontrado',
            ], 404);
        }

        $rutina->rut_repeticiones = $request->rut_repeticiones ?? $rutina->rut_repeticiones;
        $rutina->rut_peso         = $request->rut_peso == 0 ? null : $request->rut_peso;
        $rutina->save();

        if (isset($request->rut_tiempo)) {
            $res = Rutinas::where('usu_id', $rutina->usu_id)->where('rut_dia', $rutina->rut_dia)->where('ejer_id', $rutina->ejer_id)->get();
            foreach ($res as $re) {
                $re->rut_tiempo = $request->rut_tiempo;
                $re->save();
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Ejercicio actualizado correctamente',
        ]);
    }

    public function destroy(string $id)
    {
        $rutina = Rutinas::where('rut_id', $id)->first();
        if (! $rutina) {
            return response()->json([
                'success' => false,
                'message' => 'Ejercicio no encontrado',
            ], 404);
        }
        $rutina->delete();

        return response()->json([
            'success' => true,
            'message' => 'Serie eliminada correctamente',
        ]);
    }

    public function rutinasUser($id)
    {
        $rutinas = DB::table('rutinas as r')
            ->join('ejercicios as e', 'r.ejer_id', '=', 'e.ejer_id')
            ->join('equipos as eq', 'e.equi_id', '=', 'eq.equi_id')
            ->join('musculo as m', 'e.mus_id', '=', 'm.mus_id')
            ->where('r.rut_estado', 'ACTIVO')
            ->where('r.usu_id', $id)
            ->orderBy('r.ejer_id', 'ASC')
            ->orderBy('r.rut_id', 'ASC')
            ->get();

        if (count($rutinas) > 0) {
            return response()->json($rutinas);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No hay rutinas registradas',
            ], 404);
        }
    }

    public function rutinasUserDia($id, $dia = null)
    {
        if (! $dia) {
            $dia = date('N');
        }

        $rutinas = DB::table('rutinas as r')
            ->join('ejercicios as e', 'r.ejer_id', '=', 'e.ejer_id')
            ->join('equipos as eq', 'e.equi_id', '=', 'eq.equi_id')
            ->join('musculo as m', 'e.mus_id', '=', 'm.mus_id')
            ->where('r.rut_estado', 'ACTIVO')
            ->where('r.usu_id', $id)
            ->where('r.rut_dia', $dia)
            ->orderBy('r.ejer_id', 'ASC')
            ->orderBy('r.rut_id', 'ASC')
            ->get();

        if (count($rutinas) > 0) {
            return response()->json($rutinas);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No hay rutinas registradas',
            ], 404);
        }
    }
}
