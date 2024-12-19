<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Costos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CostosController extends Controller
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
        $costos = Costos::where('estado', 'ACTIVO')->get();
        return view('backend.pages.costos.index', compact('costos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.costos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('cliente.view')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún usuario!');
        }
        // dd($request);
        // die();
        $request->validate([
            'periodo' => 'required',
            'monto' => 'required|numeric',
        ]);

        $newCosto = new Costos();
        $newCosto->nombre = $request->nombre;
        $newCosto->tipo = $request->tipo;
        $newCosto->periodo = $request->periodo;
        $newCosto->monto = $request->monto;
        $newCosto->mes = $request->meses;
        $newCosto->ingreso_dia = $request->ingreso_dia;
        $newCosto->ingreso_semana = $request->ingreso_semana;
        $newCosto->save();

        session()->flash('success', '¡¡Se ha creado el costo!!');
        return redirect()->route('admin.costos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Costos $costos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        if (is_null($this->user) || !$this->user->can('costo.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún costo!');
        }

        $costo = Costos::find($id);
        return view('backend.pages.costos.edit', compact('costo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        if (is_null($this->user) || !$this->user->can('costo.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún costo!');
        }
        $request->validate([
            'periodo' => 'required',
            'monto' => 'required|numeric',
        ]);

        $editCosto = Costos::find($id);
        $editCosto->nombre = $request->nombre;
        $editCosto->tipo = $request->tipo;
        $editCosto->periodo = $request->periodo;
        $editCosto->monto = $request->monto;
        $editCosto->mes = $request->meses;
        $editCosto->ingreso_dia = $request->ingreso_dia;
        $editCosto->ingreso_semana = $request->ingreso_semana;
        $editCosto->save();

        session()->flash('success', '¡¡Se ha modificado el costo!!');
        return redirect()->route('admin.costos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        if (is_null($this->user) || !$this->user->can('costo.view')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a eliminar ningún costo!');
        }
        if ($id === 1) {
            session()->flash('error', 'Lo siento !! ¡No estás autorizado a eliminar este costo!');
            return back();
        }

        $costo = Costos::find($id);
        $costo->estado = 'ELIMINADO';
        $costo->save();
        // $costo->delete();


        session()->flash('success', '¡¡El costo ha sido eliminado!!');
        return back();
    }
}
