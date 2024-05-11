<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuarios;
use App\Models\Asistencia;

class UsuarioController extends Controller
{
    public function index(){

        return null;
    }

    public function registrar_asistencia(Request $request)
    {
        $ciUsuario = $request->input('ci_usuario');
        $user = Usuarios::where('ci_usuario', $ciUsuario)->first();
        if($user) {
            // Buscamos si ya existe una asistencia para el usuario en la fecha actual.
            $asistencia = Asistencia::where('asistencia_fecha', date('Y-m-d'))
                                     ->where('usu_id', $user->usu_id)
                                     ->first();
            if($asistencia) {
                // Si ya hay una asistencia para el usuario en la fecha actual...
                if ($asistencia->asistencia_tipo === 'SALIDA') {
                    // Si la asistencia es una salida, significa que el usuario está marcando una entrada nuevamente.
                    $asistencia = new Asistencia();
                    $asistencia->usu_id = $user->usu_id;
                    $asistencia->asistencia_fecha = date('Y-m-d');
                    $asistencia->asistencia_hora = date('H:i:s');
                    $asistencia->asistencia_tipo = 'ENTRADA';
                } else {
                    // Si la asistencia es una entrada, comprobamos si han pasado al menos una hora desde la entrada.
                    $horaEntrada = strtotime($asistencia->asistencia_hora);
                    $horaActual = time();
                    $diferenciaHoras = ($horaActual - $horaEntrada) / 3600; // Convertir diferencia de segundos a horas

                    if ($diferenciaHoras >= 1) {
                        // Si han pasado al menos una hora desde la entrada, el usuario puede registrar la salida.
                        $asistencia->asistencia_tipo = 'SALIDA';
                    } else {
                        // Si no ha pasado suficiente tiempo desde la entrada, no se puede registrar la salida.
                        return response()->json([
                            'success' => false,
                            'message' => 'No se puede registrar la salida. No han pasado suficientes horas desde la entrada.'
                        ], 400);
                    }
                }
            } else {
                // Si no hay asistencia para el usuario en la fecha actual, esto significa que está marcando la entrada.
                $asistencia = new Asistencia();
                $asistencia->usu_id = $user->usu_id;
                $asistencia->asistencia_fecha = date('Y-m-d');
                $asistencia->asistencia_hora = date('H:i:s');
                $asistencia->asistencia_tipo = 'ENTRADA';
            }

            $asistencia->save();

            return response()->json([
                'success' => true,
                'data' => ($asistencia->asistencia_tipo == 'ENTRADA') ? 'Asistencia ENTRADA' : 'Asistencia SALIDA'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }
    }
    public function usuario($ci){
        $user = Usuarios::where('ci_usuario', $ci)->first();
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
        $ciUsuario = $request->input('ci_usuario');
        $user = Usuarios::where('ci_usuario', $ciUsuario)->first();
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
