<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ejercicios;
use Illuminate\Support\Facades\DB;

class EjerciciosController extends Controller
{
    public function ejerciciosApp()
    {
        $ejercicios = DB::table('ejercicios as e')
            ->join('equipos as eq', 'eq.equi_id', '=', 'e.equi_id')
            ->join('musculo as m', 'm.mus_id', '=', 'e.mus_id')
            ->where('e.ejer_estado', 'ACTIVO')
            ->get();

        return response()->json($ejercicios);
    }
}
