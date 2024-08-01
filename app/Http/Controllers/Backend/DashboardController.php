<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Asistencia;
use App\Models\Costos;
use App\Models\Pagos;
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

        $inicioMesActual = Carbon::now()->startOfMonth()->day(10)->toDateString();
        $finMesSiguiente = Carbon::now()->addMonth()->startOfMonth()->day(9)->toDateString();
        $registrosMesActual = Usuarios::whereBetween('created_at', [$inicioMesActual, $finMesSiguiente])->count();

        $inicioMesAnterior = Carbon::now()->subMonth()->startOfMonth()->day(10)->toDateString();
        $finMesAnterior = Carbon::now()->subMonth()->endOfMonth()->toDateString();
        $registrosMesAnterior = Usuarios::whereBetween('created_at', [$inicioMesAnterior, $finMesAnterior])->count();

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

        // $currentYear = Carbon::now()->year;
        // $currentMonth = Carbon::now()->month;
        // $pagos = Pagos::whereYear('pago_fecha', $currentYear)
        //     ->whereMonth('pago_fecha', $currentMonth)
        //     ->whereDay('pago_fecha', 10)
        //     ->orderBy('pago_id', 'DESC')
        //     ->get();
        $pagos = Pagos::orderBy('pago_id', 'DESC')->get();

        $totalUsuarios = 0;
        foreach ($pagos as $pago) {
            $fechaPago = new \DateTime($pago->pago_fecha);

            $fechaLimite = clone $fechaPago;
            $fechaLimite->modify('+' . $pago->costo->mes * 30 . ' days');

            $fechaActual = today();

            $diff = $fechaActual->diff($fechaLimite);
            $diferenciaDias = $diff->format('%r%a');

            // if ($diferenciaDias > 0) {
            //     if ($diferenciaDias >= 30) {
            //         $textoFaltante = '30 días';
            //     } else {
            //         $textoFaltante = "$diferenciaDias días";
            //     }
            // } elseif ($diferenciaDias == 0) {
            //     $textoFaltante = 'Hoy es el último día';
            // } else {
            //     $textoFaltante = 0;
            // }

            if ($diferenciaDias >= 0) {
                $totalUsuarios++;
            }
        }

        if ($totalUsuarios > 0) {
            $porcentajeAsistentes = ($asistenciasHoy / $totalUsuarios) * 100;
        } else {
            $porcentajeAsistentes = 0;
        }

        $porcentajeAsistentesF = number_format($porcentajeAsistentes, 2);
        $porcentajeAsistentesFS = $porcentajeAsistentes > 0 ? '+' . $porcentajeAsistentesF : $porcentajeAsistentesF;

        $costos = Costos::with('pagosMesAnterior')->get();

        $total = array(
            'total_users' => $total_users,
            'users' => $registrosMesActual,
            'users_total' => $crecimientoFS,
            'asistencias' => $asistenciasHoy,
            'porcentaje_asistencias' => $porcentajeAsistentesFS,
        );
        return view('backend.pages.dashboard.index', compact('total_admins', 'total_roles', 'total_permissions', 'total', 'costos'));
    }
}
