<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
// use App\Models\Asistencia;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index()
    {
        return null;
    }

    public function registrar_asistencia(Request $request)
    {
        $ciUsuario = $request->input('usu_ci');
        $user = Usuarios::where('usu_ci', $ciUsuario)->where('usu_estado', 'ACTIVO')->first();

        if ($user && $user->usu_huella == true) {
            $asistencia = DB::table('asistencia')
                ->where('asistencia.asistencia_fecha', date('Y-m-d'))
                ->where('asistencia.usu_id', $user->usu_id)
                ->orderBy('asistencia.asistencia_id', 'desc')
                ->select('asistencia.*') // Selecciona las columnas que necesites
                ->first();

            $asistenciasDia = DB::table('asistencia')
                ->where('asistencia.asistencia_fecha', date('Y-m-d'))
                ->where('asistencia.usu_id', $user->usu_id)
                ->orderBy('asistencia.asistencia_id', 'desc')
                ->select('asistencia.*') // Selecciona las columnas que necesites
                ->get();

            $asistenciasSemana = DB::table('asistencia')
                ->select('asistencia_fecha')
                ->whereYear('asistencia_fecha', '=', DB::raw('YEAR(CURDATE())'))
                ->whereRaw('WEEK(asistencia_fecha, 1) = WEEK(CURDATE(), 1)')
                ->where('usu_id', '=', $user->usu_id)
                ->groupBy('asistencia_fecha')
                ->orderBy('asistencia_id', 'DESC')
                ->get();

            $pagos = DB::table('usuarios')
                ->join('pagos', 'usuarios.usu_id', '=', 'pagos.usu_id')
                ->join('costos', 'pagos.costo_id', '=', 'costos.costo_id')
                ->where('usuarios.usu_id', $user->usu_id)
                ->orderBy('pagos.actualizado_en', 'desc')
                ->select('costos.*', 'pagos.pago_fecha') // Selecciona las columnas que necesites
                ->first();

            // return response()->json([
            //     'message' => $asistenciasDia,
            // ]);
            // die();

            if (!$pagos) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron pagos para este usuario.',
                ], 404);
            }

            // Convertir la fecha de pago a objeto DateTime para asegurar el formato
            $fechaPago = new \DateTime($pagos->pago_fecha);

            // Calcular la fecha límite para completar el mes
            $fechaLimite = clone $fechaPago;
            $fechaLimite->modify('+' . $pagos->mes . ' month'); // Sumar el número de meses especificado

            // Calcular la diferencia en días entre la fecha límite y la fecha actual
            $fechaActual = new \DateTime(); // Fecha actual sin la hora (00:00:00)
            $diff = $fechaActual->diff($fechaLimite);
            $diferenciaDias = $diff->format('%r%a'); // Obtener la diferencia en días con el signo

<<<<<<< HEAD
            if ($diferenciaDias < 1) {
                return response()->json([
                    'success' => false,
                    'message' => "No hay fecha de pago o no cumple con el plazo para completar el mes.",
                ], 400);
=======
            // Verificar si se encontró algún pago actual para el usuario
            if (intval($diferenciaDias) <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró un pago actual para este usuario.',
                ], 404);
>>>>>>> dev
            }

            // Construir el mensaje de respuesta
            $mensajeAsistencia = ($asistencia && $asistencia->asistencia_tipo == 'ENTRADA') ? 'Asistencia SALIDA' : 'Asistencia ENTRADA';
            $textoDiasFaltantes = "Faltan $diferenciaDias días.";

            // Determinar el tipo de asistencia
            if ($asistencia) {
                if ($asistencia->asistencia_tipo === 'SALIDA') {
                    if (count($asistenciasDia) / 2 < $pagos->ingreso_dia) {
                        $nuevaAsistencia = [
                            'usu_id' => $user->usu_id,
                            'asistencia_fecha' => date('Y-m-d'),
                            'asistencia_hora' => date('H:i:s'),
                            'asistencia_tipo' => 'ENTRADA',
                        ];

                        DB::table('asistencia')->insert($nuevaAsistencia);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Solo puede ingresar ' . $pagos->ingreso_dia . ' ' . ($pagos->ingreso_dia > 1 ? 'veces' : 'vez') . ' al dia.',
                        ], 400);
                    }
                } else {
                    $horaEntrada = strtotime($asistencia->asistencia_hora);
                    $horaActual = time();
                    $diferenciaHoras = ($horaActual - $horaEntrada) / 3600;

                    if ($diferenciaHoras >= 1) {
                        $nuevaAsistencia = [
                            'usu_id' => $user->usu_id,
                            'asistencia_fecha' => date('Y-m-d'),
                            'asistencia_hora' => date('H:i:s'),
                            'asistencia_tipo' => 'SALIDA',
                        ];

                        DB::table('asistencia')->insert($nuevaAsistencia);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'No se puede registrar la salida. No han pasado suficientes horas desde la entrada. ' . $textoDiasFaltantes,
                        ], 400);
                    }
                }
            } else {
                if (count($asistenciasSemana) < $pagos->ingreso_semana) {
                    $nuevaAsistencia = [
                        'usu_id' => $user->usu_id,
                        'asistencia_fecha' => date('Y-m-d'),
                        'asistencia_hora' => date('H:i:s'),
                        'asistencia_tipo' => 'ENTRADA',
                    ];

                    DB::table('asistencia')->insert($nuevaAsistencia);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Solo puede ingresar ' . $pagos->ingreso_semana . ' ' . ($pagos->ingreso_semana > 1 ? 'veces' : 'vez') . ' a la semana.',
                    ], 400);
                }
            }

            return response()->json([
                'success' => true,
                'data' => $mensajeAsistencia . " " . $textoDiasFaltantes,
                'message' => 'Le quedan ' . $diferenciaDias . ' días.',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado',
            ], 404);
        }
    }

    public function usuario($ci)
    {
        $user = Usuarios::where('usu_ci', $ci)->first();
        if ($user) {
            return response()->json([
                'success' => true,
                'data' => [
                    'ci' => $user->usu_ci,
                    'nombre' => $user->usu_nombre,
                    'apellido' => $user->usu_apellidos,
                    'huella' => $user->usu_huella,
                ],
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => 'Usuario no encontrado',
            ], 404);
        }
    }

    public function huella(Request $request)
    {
        $ciUsuario = $request->input('usu_ci');
        $user = Usuarios::where('usu_ci', $ciUsuario)->first();
        if ($user) {
            $user->usu_huella = true; // Asigna el nuevo valor al campo usu_huella
            $user->save(); // Guarda los cambios en la base de datos
            return response()->json([
                'success' => true,
                'data' => 'Huella Creado',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => 'Usuario no encontrado',
            ], 404);
        }
    }
}
