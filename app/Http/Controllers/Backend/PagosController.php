<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Costos;
use App\Models\Pagos;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagosController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $costos = Costos::all();
        $usuarios = Usuarios::where('usu_estado', 'ACTIVO')->get();
        $pagos = Pagos::all();
        return view('backend.pages.pagos.index', compact('costos', 'pagos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Usuarios::where('usu_estado', 'ACTIVO')->get();
        $costos = Costos::all();
        return view('backend.pages.pagos.create', compact('clientes', 'costos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('pago.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún pago!');
        }
        // dd($request);
        // die();
        $request->validate([
            'usu_id' => 'required',
            'monto' => 'required|numeric',
            'costo_id' => 'required',
            'fecha' => 'required',
            'metodo' => 'required',
        ]);

        $newPago = new Pagos();
        $newPago->usu_id = $request->usu_id;
        $newPago->pago_monto = $request->monto;
        $newPago->costo_id = $request->costo_id;
        $newPago->pago_fecha = $request->fecha;
        $newPago->pago_metodo = $request->metodo;
        $newPago->pago_observaciones = $request->observaciones;
        $newPago->save();

        session()->flash('success', '¡¡Se ha creado el registro!!');
        return redirect()->route('admin.pagos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (is_null($this->user) || !$this->user->can('pago.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún registro!');
        }

        $pago = Pagos::find($id);
        $clientes = Usuarios::where('usu_estado', 'ACTIVO')->get();
        $costos = Costos::all();
        return view('backend.pages.pagos.edit', compact('pago', 'clientes', 'costos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (is_null($this->user) || !$this->user->can('pago.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún registro!');
        }
        $request->validate([
            'usu_id' => 'required',
            'monto' => 'required|numeric',
            'costo_id' => 'required',
            'fecha' => 'required',
            'metodo' => 'required',
            'estado' => 'required',
        ]);

        $editPago = Pagos::find($id);
        $editPago->usu_id = $request->usu_id;
        $editPago->pago_monto = $request->monto;
        $editPago->costo_id = $request->costo_id;
        $editPago->pago_fecha = $request->fecha;
        $editPago->pago_metodo = $request->metodo;
        $editPago->pago_observaciones = $request->observaciones;
        $editPago->pago_estado = $request->estado;
        $editPago->save();

        session()->flash('success', '¡¡Se ha modificado el registro!!');
        return redirect()->route('admin.pagos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (is_null($this->user) || !$this->user->can('pago.delete')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a eliminar ningún registro!');
        }
        if ($id === 1) {
            session()->flash('error', 'Lo siento !! ¡No estás autorizado a eliminar este registro!');
            return back();
        }

        $pago = Pagos::find($id);
        $pago->pago_estado = 'CANCELADO';
        // Guardar los cambios en la base de datos
        $pago->save();

        session()->flash('success', '¡¡El registro ha sido eliminado!!');
        return back();
    }
}
