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

        $inicioSemanaActual = Carbon::now()->startOfWeek();
        $finSemanaActual = Carbon::now()->endOfWeek();
        $registrosSemanaActual = Usuarios::whereBetween('created_at', [$inicioSemanaActual, $finSemanaActual])->count();

        $inicioSemanaPasada = Carbon::now()->subWeek()->startOfWeek();
        $finSemanaPasada = Carbon::now()->subWeek()->endOfWeek();
        $registrosSemanaPasada = Usuarios::whereBetween('created_at', [$inicioSemanaPasada, $finSemanaPasada])->count();

        if ($registrosSemanaPasada > 0) {
            $crecimiento = (($registrosSemanaActual - $registrosSemanaPasada) / $registrosSemanaPasada) * 100;
        } else {
            $crecimiento = $registrosSemanaActual > 0 ? 100 : 0;
        }

        $crecimientoF = number_format($crecimiento, 2);
        $crecimientoFS = $crecimiento > 0 ? '+' . $crecimientoF : $crecimientoF;

        $hoy = Carbon::now()->startOfDay();
        $asistenciasHoy = Asistencia::where('asistencia_tipo', 'ENTRADA')
            ->whereDate('asistencia_fecha', $hoy)
            ->count();

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

        $costos = Costos::all();

        $total = array(
            'total_users' => $total_users,
            'week_users' => $registrosSemanaActual,
            'week_users_total' => $crecimientoFS,
            'asistencias' => $asistenciasHoy,
            'porcentaje_asistencias' => $porcentajeAsistentesFS,
        );
        return view('backend.pages.dashboard.index', compact('total_admins', 'total_roles', 'total_permissions', 'total', 'costos'));
    }
}
