<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Medidas;
use Illuminate\Http\Request;

class MedidasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        session()->flash('success', '¡¡Medidas antropométricas agregadas!!');
        return redirect()->back();
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
