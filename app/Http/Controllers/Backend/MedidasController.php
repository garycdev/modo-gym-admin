<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Medidas;
use App\Models\MedidasDetalle;
use App\Models\UsuarioLogin;
use Illuminate\Http\Request;

class MedidasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = UsuarioLogin::all();
        return view('backend.pages.medidas.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $medidas                  = new Medidas();
        $medidas->usu_id          = $request->usu_id;
        $medidas->peso            = $request->peso;
        $medidas->imc             = $request->imc;
        $medidas->grasa           = $request->grasa;
        $medidas->icc             = $request->icc;
        $medidas->rcv             = $request->rcv;
        $medidas->peso_ideal      = $request->peso_ideal;
        $medidas->xmes            = $request->xmes;
        $medidas->tiempo_estimado = $request->tiempo_estimado;
        // $medidas->brazo           = $request->brazo;
        // $medidas->antebrazo       = $request->antebrazo;
        // $medidas->torso           = $request->torso;
        // $medidas->cintura_es      = $request->cintura_es;
        // $medidas->cintura_om      = $request->cintura_om;
        // $medidas->cadera          = $request->cadera;
        // $medidas->muslo           = $request->muslo;
        // $medidas->pierna          = $request->pierna;
        // $medidas->pcb             = $request->pcb;
        // $medidas->pct             = $request->pct;
        // $medidas->pse             = $request->pse;
        // $medidas->psi             = $request->psi;
        $medidas->save();

        session()->flash('success', '¡¡Medidas antropométricas agregadas!!');
        return redirect()->route('admin.medidas.show', $medidas->med_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $medidas   = Medidas::findOrFail($id);
        $registros = MedidasDetalle::where('med_estado', 'ACTIVO')
            ->orderByDesc('created_at')
            ->where('med_id', $id)
            ->take(10)
            ->get()
            ->sortBy('created_at');

        $fechas = $registros->pluck('created_at')->map(function ($fecha) {
            return \Carbon\Carbon::parse($fecha)->format('d-m-Y');
        });

        $datos = ['brazo', 'antebrazo', 'torso', 'cintura_es', 'cintura_om', 'cadera', 'muslo', 'pierna', 'pcb', 'pct', 'pse', 'psi'];

        $data = [];

        foreach ($datos as $medida) {
            foreach ($registros as $registro) {
                $fecha                 = \Carbon\Carbon::parse($registro->created_at)->format('d-m-Y');
                $data[$medida][$fecha] = $registro->$medida;
            }
        }

        return view('backend.pages.medidas.edit', compact('medidas', 'fechas', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $medidas                  = Medidas::findOrFail($id);
        $medidas->usu_id          = $request->usu_id;
        $medidas->peso            = $request->peso;
        $medidas->imc             = $request->imc;
        $medidas->grasa           = $request->grasa;
        $medidas->icc             = $request->icc;
        $medidas->rcv             = $request->rcv;
        $medidas->peso_ideal      = $request->peso_ideal;
        $medidas->xmes            = $request->xmes;
        $medidas->tiempo_estimado = $request->tiempo_estimado;
        $medidas->brazo           = $request->brazo;
        $medidas->antebrazo       = $request->antebrazo;
        $medidas->torso           = $request->torso;
        $medidas->cintura_es      = $request->cintura_es;
        $medidas->cintura_om      = $request->cintura_om;
        $medidas->cadera          = $request->cadera;
        $medidas->muslo           = $request->muslo;
        $medidas->pierna          = $request->pierna;
        $medidas->pcb             = $request->pcb;
        $medidas->pct             = $request->pct;
        $medidas->pse             = $request->pse;
        $medidas->psi             = $request->psi;
        $medidas->save();

        session()->flash('success', '¡¡Medidas antropométricas actualizadas!!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
