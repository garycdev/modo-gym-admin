<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Asistencia;
use App\Models\Costos;
use App\Models\Pagos;
use App\Models\Rutinas;
use App\Models\Usuarios;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public $user;
    public $guard;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::guard('admin')->check()) {
                $this->user = Auth::guard('admin')->user();
            } else {
                $this->user = Auth::guard('user')->user();
            }

            return $next($request);
        });
    }

    public function index()
    {
        if (is_null($this->user) || !$this->user->can('dashboard.view')) {
            abort(403, 'Lo sentimos !! No estas autorizado para ver el panel !');
        }

        $total_roles = Role::select('id')->count();
        $total_admins = Admin::select('id')->count();
        $total_permissions = Permission::select('id')->count();

        // Total de usuarios registrados
        $total_users = Usuarios::where('usu_estado', '<>', 'ELIMINADO')->count();

        // Obtener usuarios respecto al mes actual y el mes anterior (10 de cada mes)
        $hoy = Carbon::now()->startOfDay();
        // Limites de fecha de mes actual y anterior
        $inicioMesActual = Carbon::now()->day(10)->startOfDay();
        $finMesActual = Carbon::now()->endOfMonth(); // Para el final del mes actual
        $inicioMesAnterior = Carbon::now()->subMonth()->day(10)->startOfDay();
        $finMesAnterior = Carbon::now()->subMonth()->day(9)->endOfDay(); // Fin del mes anterior

        // Validar el 10 de cada mes para el mes actual
        if ($hoy->day < 10) {
            // Si hoy es antes del 10, contar desde el 10 del mes anterior
            $registrosMesActual = Usuarios::whereBetween('created_at', [$inicioMesAnterior, $hoy])->count();
            $inicioMesAntepasado = Carbon::now()->subMonths(2)->day(10)->startOfDay();
            $finMesAnterior = Carbon::now()->subMonth()->day(9)->endOfDay();
            $registrosMesAnterior = Usuarios::whereBetween('created_at', [$inicioMesAntepasado, $finMesAnterior])->count();
        } else {
            // Si hoy es el 10 o después del 10, contar desde el 10 del mes actual
            $registrosMesActual = Usuarios::whereBetween('created_at', [$inicioMesActual, $hoy])->count();
            $registrosMesAnterior = Usuarios::whereBetween('created_at', [$inicioMesAnterior, $finMesAnterior])->count();
        }

        if ($registrosMesAnterior > 0) {
            $crecimiento = (($registrosMesActual - $registrosMesAnterior) / $registrosMesAnterior) * 100;
        } else {
            $crecimiento = $registrosMesActual > 0 ? 100 : 0;
        }

        $crecimientoF = number_format($crecimiento, 2);
        $crecimientoFS = $crecimiento > 0 ? '+' . $crecimientoF : $crecimientoF;

        // Obtener asistencias de hoy y ayer (ENTRADAS)
        $hoy = Carbon::now()->startOfDay();
        $asistenciasHoy = Asistencia::where('asistencia_tipo', 'ENTRADA')
            ->whereDate('asistencia_fecha', $hoy)
            ->count();
        $ayer = Carbon::now()->subDay()->startOfDay();
        $asistenciasAyer = Asistencia::where('asistencia_tipo', 'ENTRADA')
            ->whereDate('asistencia_fecha', $ayer)
            ->count();

        // Obtener porcentaje de asistencias (hoy vs ayer)
        $porcentaje = 0;
        if ($asistenciasAyer > 0) {
            $porcentaje = (($asistenciasHoy - $asistenciasAyer) / $asistenciasAyer) * 100;
        }

        $porcentajeFormateado = number_format($porcentaje, 2);
        $porcentajeFormateado = ($porcentaje >= 0 ? '+' : '') . $porcentajeFormateado;

        // Obtener costos para mes actual y el mes anterior
        // Esta definido por scopes (scopeMesActual y scopeMesAnterior) en el modelo Pagos
        $costos = Costos::with('pagosMesActual')->with('pagosMesAnterior')->get();

        // Porcentaje de usuarios respecto al total de usuarios
        $porcentaje_users = ($registrosMesActual * 100) / $total_users;
        $porcentajeUsersFormateado = ($porcentaje_users >= 0 ? '+' : '') . number_format($porcentaje_users, 2);

        // Valores de los totales y porcentajes
        $total = array(
            'total_users' => $total_users,
            'porcentaje_users' => $porcentajeUsersFormateado,
            'users' => $registrosMesActual,
            'users_total' => $crecimientoFS,
            'asistencias' => $asistenciasHoy,
            'porcentaje_asistencias' => $porcentajeFormateado,
        );

        $user = array(
            'asistencias' => 0,
            'pagos' => 0,
            'rutinas' => 0,
        );
        if (Auth::guard('user')->check()) {
            $user['asistencias'] = Asistencia::where('usu_id', Auth::guard('user')->user()->usu_id)
                ->where('asistencia_tipo', 'ENTRADA')
                ->count();
            $user['pagos'] = Pagos::where('usu_id', Auth::guard('user')->user()->usu_id)
                ->count();
            $user['rutinas'] = Rutinas::where('usu_id', Auth::guard('user')->user()->usu_id)
                ->count();
        }
        return view('backend.pages.dashboard.index', compact('total_admins', 'total_roles', 'total_permissions', 'total', 'costos', 'user'));

    }
}
