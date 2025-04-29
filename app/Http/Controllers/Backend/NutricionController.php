<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Nutricion;
use Illuminate\Http\Request;

class NutricionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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
        $nutricion                                  = new Nutricion();
        $nutricion->usu_id                          = $request->usu_id;
        $nutricion->nombre                          = $request->nombre;
        $nutricion->edad                            = $request->edad;
        $nutricion->fecha                           = $request->fecha;
        $nutricion->antecedentes_medicos_familiares = $request->antecedentes;
        $nutricion->hijos                           = $request->hijos;
        $nutricion->ciclo_menstrual                 = $request->ciclo;
        $nutricion->medicamentos                    = $request->medicamentos;
        $nutricion->objetivo                        = $request->objetivo;
        $nutricion->intolerancias_alergias          = $request->intolerancias_alergias;
        $nutricion->habito                          = $request->habito;
        $nutricion->alcohol                         = $request->alcohol;
        $nutricion->tabaco                          = $request->tabaco;
        $nutricion->actividad_fisica                = $request->fisica;
        $nutricion->save();

        session()->flash('success', '¡¡Evaluación nutricional agregada!!');
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
        $nutricion                                  = Nutricion::findOrFail($id);
        $nutricion->usu_id                          = $request->usu_id;
        $nutricion->nombre                          = $request->nombre;
        $nutricion->edad                            = $request->edad;
        $nutricion->fecha                           = $request->fecha;
        $nutricion->antecedentes_medicos_familiares = $request->antecedentes;
        $nutricion->hijos                           = $request->hijos;
        $nutricion->ciclo_menstrual                 = $request->ciclo;
        $nutricion->medicamentos                    = $request->medicamentos;
        $nutricion->objetivo                        = $request->objetivo;
        $nutricion->intolerancias_alergias          = $request->intolerancias_alergias;
        $nutricion->habito                          = $request->habito;
        $nutricion->alcohol                         = $request->alcohol;
        $nutricion->tabaco                          = $request->tabaco;
        $nutricion->actividad_fisica                = $request->fisica;
        $nutricion->save();

        session()->flash('success', '¡¡Evaluación nutricional actualizada!!');
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
