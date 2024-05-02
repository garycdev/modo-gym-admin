<?php

namespace App\Http\Contrutinalers\Backend;

use App\Http\Contrutinalers\Contrutinaler;
use Illuminate\Http\Request;

use App\Models\Rutinas;
use App\Models\Costos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;


class RutinasContrutinaler extends Contrutinaler
{
    /**
     * Display a listing of the resource.
     */
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('rutina.view')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a ver ningún rutina!');
        }

        $rutinas = Rutinas::all();
        return view('backend.pages.rutina.index', compact('rutinas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('rutina.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún rutina!');
        }

        $costos  = Costos::all();
        return view('backend.pages.rutinas.create', compact('costos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('rutina.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún rutina!');
        }

        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:rutinas'
        ], [
            'name.requried' => 'Por favor proporcione un nombre de rutina'
        ]);

        // Process Data
        $rutina = Rutinas::create([
            'name' => $request->name,
            'guard_name' => 'admin'
        ]);

        // $rutinae = DB::table('rutinaes')->where('name', $request->name)->first();

        session()->flash('success', '¡¡El rutina ha sido creado!!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        if (is_null($this->user) || !$this->user->can('rutina.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún rutina!');
        }

        $rutina = Rutinas::find($id);
        return view('backend.pages.rutinas.edit', compact('rutina'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        if (is_null($this->user) || !$this->user->can('rutina.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún rutina!');
        }

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin rutinae,
        // so that no-one could delete or disable it by somehow.
        if ($id === 1) {
            session()->flash('error', 'Lo siento !! ¡No estás autorizado a editar este rutina!');
            return back();
        }

        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:rutinaes,name,' . $id
        ], [
            'name.requried' => 'Por favor proporcione un nombre de rutina'
        ]);

        // Create New Admin
        $rutina = Rutinas::find($id);

        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:admins,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->username = $request->username;

        $admin->save();

        session()->flash('success', '¡¡El rutina ha sido actualizado!!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('rutina.delete')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a eliminar ningún rutina!');
        }

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin rutinae,
        // so that no-one could delete or disable it by somehow.
        if ($id === 1) {
            session()->flash('error', 'Lo siento !! ¡No estás autorizado a eliminar este rutina!');
            return back();
        }

        $rutina = Rutinas::find($id);
        if (!is_null($rutina)) {
            $rutina->delete();
        }

        session()->flash('success', '¡¡El rutina ha sido eliminado!!');
        return back();
    }
}
