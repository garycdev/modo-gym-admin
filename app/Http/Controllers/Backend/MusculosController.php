<?php

namespace App\Http\Controllers\Backend;

use App\Models\Musculo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class MusculosController extends Controller
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
        if (is_null($this->user) || !$this->user->can('musculo.view')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a ver ningún Musculo!');
        }

        $musculos = Musculo::where('mus_estado', '!=', 'ELIMINADO')->get();
        return view('backend.pages.musculos.index', compact('musculos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('musculo.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún Musculo!');
        }
        return view('backend.pages.musculos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('musculo.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún musculo!');
        }

        // Validation Data
        $request->validate([
            'mus_nombre' => 'required|string|max:150',
            'mus_imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        // Create New Musculo
        $musculo = new Musculo();
        $musculo->mus_nombre = $request->mus_nombre;
        // Procesamiento de la imagen
        if ($request->hasFile('mus_imagen')) {
            // Eliminar la imagen existente
            // if (file_exists(public_path($musculo->mus_imagen))) {
            //     unlink(public_path($musculo->mus_imagen));
            // }
            $image = $request->file('mus_imagen');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = public_path('image/modo-gym');
            $image->move($imagePath, $imageName); // Mueve la imagen a la carpeta de uploads/informacion
            // Actualiza el campo info_logo con el nombre de la nueva imagen
            $musculo->mus_imagen = 'image/modo-gym'.'/'.$imageName;
        }else {
            // Si no se proporciona ningún archivo, no realices ningún procesamiento y simplemente mantén el valor actual del campo info_logo
            $musculo->mus_imagen = $musculo->mus_imagen; // Asegúrate de que esto sea correcto para mantener el valor actual
        }

        $musculo->save();


        session()->flash('success', '¡¡Se ha creado los musculos!!');
        return redirect()->route('admin.musculos.index');
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
        if (is_null($this->user) || !$this->user->can('musculo.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún musculo!');
        }

        $musculo = Musculo::find($id);
        return view('backend.pages.musculos.edit', compact('musculo'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (is_null($this->user) || !$this->user->can('musculo.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún musculo!');
        }
        // Validación de los datos del formulario
        $request->validate([
            'mus_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Validación de la imagen
            'mus_nombre' => 'required|max:255',
            'mus_estado' => 'required|string|max:20'
        ]);
        // Obtener el registro de la base de datos
        $musculos = Musculo::find($id);
        // Actualizar los campos del registro con los datos del formulario
        $musculos->mus_nombre = $request->mus_nombre;
        $musculos->mus_estado = $request->mus_estado;

        // Procesamiento de la imagen
        if ($request->hasFile('mus_imagen')) {
            // Eliminar la imagen existente
            if (file_exists(public_path($musculos->mus_imagen))) {
                unlink(public_path($musculos->mus_imagen));
            }
            $image = $request->file('mus_imagen');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = public_path('image/modo-gym');
            $image->move($imagePath, $imageName); // Mueve la imagen a la carpeta de uploads/informacion
            // Actualiza el campo mus_imagen con el nombre de la nueva imagen
            $musculos->mus_imagen = 'image/modo-gym'.'/'.$imageName;
        }else {
            // Si no se proporciona ningún archivo, no realices ningún procesamiento y simplemente mantén el valor actual del campo info_logo
            $musculos->mus_imagen = $musculos->mus_imagen; // Asegúrate de que esto sea correcto para mantener el valor actual
        }

        // Guardar los cambios en la base de datos
        $musculos->save();

        // Redireccionar de vuelta con un mensaje de éxito
        session()->flash('success', '¡¡La información ha sido actualizada con éxito!!');
        return back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (is_null($this->user) || !$this->user->can('musculo.delete')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a eliminar ningún musculo!');
        }
        if ($id === 1) {
            session()->flash('error', 'Lo siento !! ¡No estás autorizado a eliminar este musculo!');
            return back();
        }

        $musculos = Musculo::find($id);
        // Eliminar la imagen existente
        if (file_exists(public_path($musculos->mus_imagen))) {
            unlink(public_path($musculos->mus_imagen));
        }
        $musculos->mus_estado = 'ELIMINADO';
        // Guardar los cambios en la base de datos
        $musculos->save();

        session()->flash('success', '¡¡El musculo ha sido eliminado!!');
        return back();
    }
}
