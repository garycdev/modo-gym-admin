<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Equipos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquiposController extends Controller
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
        if (is_null($this->user) || !$this->user->can('equipo.view')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a ver ningún Equipos!');
        }

        $equipos = Equipos::where('equi_estado', '!=', 'ELIMINADO')->get();
        return view('backend.pages.equipos.index', compact('equipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('equipo.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún equipo!');
        }
        return view('backend.pages.equipos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('equipo.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún equipo!');
        }
        // dd($request);
        // die();

        // Validation Data
        $request->validate([
            'equi_nombre' => 'required|string|max:150',
            'equi_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        // Create New Equipo
        $equipo = new Equipos();
        $equipo->equi_nombre = $request->equi_nombre;
        // Procesamiento de la imagen
        if ($request->hasFile('equi_imagen')) {
            // Eliminar la imagen existente
            // if (file_exists(public_path($equipo->equi_imagen))) {
            //     unlink(public_path($equipo->equi_imagen));
            // }
            $image = $request->file('equi_imagen');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('image/modo-gym');
            $image->move($imagePath, $imageName); // Mueve la imagen a la carpeta de uploads/informacion
            // Actualiza el campo info_logo con el nombre de la nueva imagen
            $equipo->equi_imagen = 'image/modo-gym' . '/' . $imageName;
        } else {
            // Si no se proporciona ningún archivo, no realices ningún procesamiento y simplemente mantén el valor actual del campo info_logo
            $equipo->equi_imagen = $equipo->equi_imagen; // Asegúrate de que esto sea correcto para mantener el valor actual
        }
        $equipo->tipo = $request->tipo;

        $equipo->save();

        session()->flash('success', '¡¡Se ha creado los Equipos!!');
        return redirect()->route('admin.equipos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (is_null($this->user) || !$this->user->can('equipo.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún equipo!');
        }

        $equipo = Equipos::find($id);
        return view('backend.pages.equipos.edit', compact('equipo'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (is_null($this->user) || !$this->user->can('equipo.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún equipo!');
        }
        // Validación de los datos del formulario
        $request->validate([
            'equi_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Validación de la imagen
            'equi_nombre' => 'required|max:255',
            'equi_estado' => 'required|string|max:20',
        ]);
        // Obtener el registro de la base de datos
        $equipos = Equipos::find($id);
        // Actualizar los campos del registro con los datos del formulario
        $equipos->equi_nombre = $request->equi_nombre;
        $equipos->equi_estado = $request->equi_estado;

        // Procesamiento de la imagen
        if ($request->hasFile('equi_imagen')) {
            // Eliminar la imagen existente
            if (file_exists(public_path($equipos->equi_imagen))) {
                unlink(public_path($equipos->equi_imagen));
            }
            $image = $request->file('equi_imagen');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('image/modo-gym');
            $image->move($imagePath, $imageName); // Mueve la imagen a la carpeta de uploads/informacion
            // Actualiza el campo equi_imagen con el nombre de la nueva imagen
            $equipos->equi_imagen = 'image/modo-gym' . '/' . $imageName;
        } else {
            // Si no se proporciona ningún archivo, no realices ningún procesamiento y simplemente mantén el valor actual del campo info_logo
            $equipos->equi_imagen = $equipos->equi_imagen; // Asegúrate de que esto sea correcto para mantener el valor actual
        }
        $equipos->tipo = $request->tipo;

        // Guardar los cambios en la base de datos
        $equipos->save();

        // Redireccionar de vuelta con un mensaje de éxito
        session()->flash('success', '¡¡La información ha sido actualizada con éxito!!');
        return redirect()->route('admin.equipos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (is_null($this->user) || !$this->user->can('equipo.delete')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a eliminar ningún equipo!');
        }
        if ($id === 1) {
            session()->flash('error', 'Lo siento !! ¡No estás autorizado a eliminar este equipo!');
            return back();
        }

        $equipos = Equipos::find($id);
        // Eliminar la imagen existente
        if (file_exists(public_path($equipos->equi_imagen))) {
            unlink(public_path($equipos->equi_imagen));
        }
        $equipos->equi_estado = 'ELIMINADO';
        // Guardar los cambios en la base de datos
        $equipos->save();

        session()->flash('success', '¡¡El equipo ha sido eliminado!!');
        return back();
    }
}
