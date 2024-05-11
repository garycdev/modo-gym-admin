<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Usuarios;
use App\Models\Asistencia;

class UsuarioController extends Controller
{
    public function index(){

        return null;
    }

    public function registrar_asistencia(Request $request)
    {
        $ciUsuario = $request->input('usu_ci');
        $user = Usuarios::where('usu_ci', $ciUsuario)->first();

        if ($user && $user->usu_huella == true) {
            $asistencia = DB::table('asistencia')
                            ->where('asistencia_fecha', date('Y-m-d'))
                            ->where('usu_id', $user->usu_id)
                            ->orderBy('asistencia_id', 'desc')
                            ->first();

            if ($asistencia) {
                if ($asistencia->asistencia_tipo === 'SALIDA') {
                    $nuevaAsistencia = [
                        'usu_id' => $user->usu_id,
                        'asistencia_fecha' => date('Y-m-d'),
                        'asistencia_hora' => date('H:i:s'),
                        'asistencia_tipo' => 'ENTRADA'
                    ];

                    DB::table('asistencia')->insert($nuevaAsistencia);
                } else {
                    $horaEntrada = strtotime($asistencia->asistencia_hora);
                    $horaActual = time();
                    $diferenciaHoras = ($horaActual - $horaEntrada) / 3600;

                    if ($diferenciaHoras >= 1) {
                        $nuevaAsistencia = [
                            'usu_id' => $user->usu_id,
                            'asistencia_fecha' => date('Y-m-d'),
                            'asistencia_hora' => date('H:i:s'),
                            'asistencia_tipo' => 'SALIDA'
                        ];

                        DB::table('asistencia')->insert($nuevaAsistencia);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'No se puede registrar la salida. No han pasado suficientes horas desde la entrada.'
                        ], 400);
                    }
                }
            } else {
                $nuevaAsistencia = [
                    'usu_id' => $user->usu_id,
                    'asistencia_fecha' => date('Y-m-d'),
                    'asistencia_hora' => date('H:i:s'),
                    'asistencia_tipo' => 'ENTRADA'
                ];

                DB::table('asistencia')->insert($nuevaAsistencia);
            }

            return response()->json([
                'success' => true,
                'data' => ($asistencia && $asistencia->asistencia_tipo == 'ENTRADA') ? 'Asistencia SALIDA' : 'Asistencia ENTRADA'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }
    }

    public function usuario($ci){
        $user = Usuarios::where('usu_ci', $ci)->first();
        if($user){
            return response()->json([
               'success' => true,
                'data' => [
                    'ci' => $user->usu_ci,
                    'nombre' => $user->usu_nombre,
                    'apellido' => $user->usu_apellidos,
                    'huella' => $user->usu_huella,
                ]
            ], 200);
        }else {
            return response()->json([
               'success' => false,
                'data' => 'Usuario no encontrado'
            ], 404);
        }
    }

    public function huella(Request $request){
        $ciUsuario = $request->input('usu_ci');
        $user = Usuarios::where('usu_ci', $ciUsuario)->first();
        if($user){
            $user->usu_huella = true; // Asigna el nuevo valor al campo usu_huella
            $user->save(); // Guarda los cambios en la base de datos
            return response()->json([
               'success' => true,
                'data' => 'Huella Creado'
            ], 200);
        }else {
            return response()->json([
               'success' => false,
                'data' => 'Usuario no encontrado'
            ], 404);
        }
    }
}
