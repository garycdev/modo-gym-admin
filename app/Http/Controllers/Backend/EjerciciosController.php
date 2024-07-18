<?php

namespace App\Http\Controllers\Backend;

use App\Models\Ejercicios;
use App\Models\Equipos;
use App\Models\Musculo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class EjerciciosController extends Controller
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
        if (is_null($this->user) || !$this->user->can('ejercicio.view')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a ver ningún Ejercicios!');
        }

        $ejercicios = Ejercicios::select('ejercicios.*', 'equipos.*', 'musculo.*')
                        ->join('equipos', 'ejercicios.equi_id', '=', 'equipos.equi_id')
                        ->join('musculo', 'ejercicios.mus_id', '=', 'musculo.mus_id')
                        ->where('ejercicios.ejer_estado', '!=', 'ELIMINADO')
                        ->where('equipos.equi_estado', '!=', 'ELIMINADO')
                        ->where('musculo.mus_estado', '!=', 'ELIMINADO')
                        ->get();

        return view('backend.pages.ejercicios.index', compact('ejercicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('ejercicio.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún ejercicios!');
        }
        $musculos = Musculo::where('mus_estado', '!=', 'ELIMINADO')->get();
        $equipos = Equipos::where('equi_estado', '!=', 'ELIMINADO')->get();

        return view('backend.pages.ejercicios.create', compact('musculos', 'equipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('ejercicio.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún ejercicio!');
        }

        // Validation Data
        $request->validate([
            'ejer_nombre' => 'required|string|max:150',
            'ejer_imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'ejer_descripcion' => 'required|string|max:50000',
            'ejer_nivel' => 'required|numeric|max:127',
        ]);
        // Create New Equipo
        $ejercicio = new Ejercicios();
        $ejercicio->ejer_nombre = $request->ejer_nombre;
        $ejercicio->ejer_descripcion = $request->ejer_descripcion;
        $ejercicio->ejer_nivel = $request->ejer_nivel;
        $ejercicio->equi_id = $request->equi_id;
        $ejercicio->mus_id = $request->mus_id;
        // Procesamiento de la imagen
        if ($request->hasFile('ejer_imagen')) {
            // Eliminar la imagen existente
            // if (file_exists(public_path($ejercicio->ejer_imagen))) {
            //     unlink(public_path($ejercicio->ejer_imagen));
            // }
            $image = $request->file('ejer_imagen');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = public_path('image/modo-gym');
            $image->move($imagePath, $imageName); // Mueve la imagen a la carpeta de uploads/informacion
            // Actualiza el campo info_logo con el nombre de la nueva imagen
            $ejercicio->ejer_imagen = 'image/modo-gym'.'/'.$imageName;
        }else {
            // Si no se proporciona ningún archivo, no realices ningún procesamiento y simplemente mantén el valor actual del campo info_logo
            $ejercicio->ejer_imagen = $ejercicio->ejer_imagen; // Asegúrate de que esto sea correcto para mantener el valor actual
        }

        $ejercicio->save();


        session()->flash('success', '¡¡Se ha creado los Ejercicios!!');
        return redirect()->route('admin.ejercicios.index');
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
        if (is_null($this->user) || !$this->user->can('ejercicio.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún ejercicio!');
        }

        $ejercicios = Ejercicios::select('ejercicios.*', 'equipos.*', 'musculo.*')
                        ->join('equipos', 'ejercicios.equi_id', '=', 'equipos.equi_id')
                        ->join('musculo', 'ejercicios.mus_id', '=', 'musculo.mus_id')
                        ->where('ejercicios.ejer_id', '=', $id)
                        ->first();


        $musculos = Musculo::where('mus_estado', '!=', 'ELIMINADO')->get();
        $equipos = Equipos::where('equi_estado', '!=', 'ELIMINADO')->get();
        return view('backend.pages.ejercicios.edit', compact('ejercicios', 'musculos', 'equipos'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (is_null($this->user) || !$this->user->can('ejercicio.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún ejercicio!');
        }
        // Validación de los datos del formulario
        $request->validate([
            'ejer_nombre' => 'required|string|max:150',
            'ejer_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'ejer_descripcion' => 'required|string|max:50000',
            'ejer_nivel' => 'required|numeric|max:127',
            'ejer_estado' => 'required|string|max:150',
        ]);
        // Obtener el registro de la base de datos
        $ejercicio = Ejercicios::find($id);
        // Actualizar los campos del registro con los datos del formulario
        $ejercicio->ejer_nombre = $request->ejer_nombre;
        $ejercicio->ejer_descripcion = $request->ejer_descripcion;
        $ejercicio->ejer_nivel = $request->ejer_nivel;
        $ejercicio->equi_id = $request->equi_id;
        $ejercicio->mus_id = $request->mus_id;
        $ejercicio->ejer_estado = $request->ejer_estado;

        // Procesamiento de la imagen
        if ($request->hasFile('ejer_imagen')) {
            // Eliminar la imagen existente
            if (file_exists(public_path($ejercicio->ejer_imagen))) {
                unlink(public_path($ejercicio->ejer_imagen));
            }
            $image = $request->file('ejer_imagen');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = public_path('image/modo-gym');
            $image->move($imagePath, $imageName); // Mueve la imagen a la carpeta de uploads/informacion
            // Actualiza el campo ejer_imagen con el nombre de la nueva imagen
            $ejercicio->ejer_imagen = 'image/modo-gym'.'/'.$imageName;
        }else {
            // Si no se proporciona ningún archivo, no realices ningún procesamiento y simplemente mantén el valor actual del campo info_logo
            $ejercicio->ejer_imagen = $ejercicio->ejer_imagen; // Asegúrate de que esto sea correcto para mantener el valor actual
        }

        // Guardar los cambios en la base de datos
        $ejercicio->save();

        // Redireccionar de vuelta con un mensaje de éxito
        session()->flash('success', '¡¡La información ha sido actualizada con éxito!!');
        return back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (is_null($this->user) || !$this->user->can('ejercicio.delete')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a eliminar ningún ejercicio!');
        }
        if ($id === 1) {
            session()->flash('error', 'Lo siento !! ¡No estás autorizado a eliminar este ejercicio!');
            return back();
        }

        $ejercicios = Ejercicios::find($id);
        // Eliminar la imagen existente
        if (file_exists(public_path($ejercicios->ejer_imagen))) {
            unlink(public_path($ejercicios->ejer_imagen));
        }
        $ejercicios->ejer_estado = 'ELIMINADO';
        // Guardar los cambios en la base de datos
        $ejercicios->save();

        session()->flash('success', '¡¡El equipo ha sido eliminado!!');
        return back();
    }
}
