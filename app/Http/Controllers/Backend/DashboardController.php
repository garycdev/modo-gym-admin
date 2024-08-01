<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Asistencia;
use App\Models\Costos;
use App\Models\Usuarios;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function index()
    {
        if (is_null($this->user) || !$this->user->can('dashboard.view')) {
            abort(403, 'Lo sentimos !! No estas autorizado para ver el panel !');
            // session()->flash('error', 'Lo sentimos !! No estas autorizado para ver el panel !');
            // return redirect()->route('admin.login');
        }

        $total_roles = Role::select('id')->count();
        $total_admins = Admin::select('id')->count();
        $total_permissions = Permission::select('id')->count();

        $total_users = Usuarios::where('usu_estado', '<>', 'ELIMINADO')->count();

        $hoy = Carbon::now()->startOfDay();
        $inicioMesActual = Carbon::now()->day(10)->startOfDay();
        $inicioMesAnterior = Carbon::now()->subMonth()->day(10)->startOfDay();
        $finMesAnterior = Carbon::now()->day(9)->endOfDay();

        if ($hoy->day < 10) {
            $registrosMesActual = Usuarios::whereBetween('created_at', [$inicioMesAnterior, $hoy])->count();
            $inicioMesAntepasado = Carbon::now()->subMonths(2)->day(10)->startOfDay();
            $finMesAnterior = Carbon::now()->subMonth()->day(9)->endOfDay();
            $registrosMesAnterior = Usuarios::whereBetween('created_at', [$inicioMesAntepasado, $finMesAnterior])->count();
        } else {
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

        $hoy = Carbon::now()->startOfDay();
        $asistenciasHoy = Asistencia::where('asistencia_tipo', 'ENTRADA')
            ->whereDate('asistencia_fecha', $hoy)
            ->count();
        $ayer = Carbon::now()->subDay()->startOfDay();
        $asistenciasAyer = Asistencia::where('asistencia_tipo', 'ENTRADA')
            ->whereDate('asistencia_fecha', $ayer)
            ->count();

        $porcentaje = 0;
        if ($asistenciasAyer > 0) {
            $porcentaje = (($asistenciasHoy - $asistenciasAyer) / $asistenciasAyer) * 100;
        }

        $porcentajeFormateado = number_format($porcentaje, 2);
        $porcentajeFormateado = ($porcentaje >= 0 ? '+' : '') . $porcentajeFormateado;

        $costos = Costos::with('pagosMesAnterior')->get();

        $porcentaje_users = ($registrosMesActual * 100) / $total_users;
        $porcentajeUsersFormateado = ($porcentaje_users >= 0 ? '+' : '') . number_format($porcentaje_users, 2);
        $total = array(
            'total_users' => $total_users,
            'porcentaje_users' => $porcentajeUsersFormateado,
            'users' => $registrosMesActual,
            'users_total' => $crecimientoFS,
            'asistencias' => $asistenciasHoy,
            'porcentaje_asistencias' => $porcentajeFormateado,
        );
        return view('backend.pages.dashboard.index', compact('total_admins', 'total_roles', 'total_permissions', 'total', 'costos'));
    }
}
