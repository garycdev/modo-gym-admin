<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rutinas;
use Illuminate\Support\Facades\DB;

class RutinasController extends Controller
{
    public function rutinasApp($id)
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
}
