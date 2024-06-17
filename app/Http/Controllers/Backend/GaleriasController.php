<?php

namespace App\Http\Controllers\Backend;


use App\Models\Galerias;
use App\Models\ImagenesGalerias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class GaleriasController extends Controller
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
        if (is_null($this->user) || !$this->user->can('galeria.view')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a ver ningún galerias!');
        }

        $galerias = Galerias::select('galerias.*', 'imagenes_galerias.*')
                        ->join('imagenes_galerias', 'imagenes_galerias.galeria_id', '=', 'galerias.galeria_id')
                        ->get();

        return view('backend.pages.galerias.index', compact('galerias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('galeria.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún galerias!');
        }
        $galerias = Galerias::all();

        return view('backend.pages.galerias.create', compact('galerias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('galeria.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún galeria!');
        }

        // Validation Data
        $request->validate([
            'galeria_nombre' => 'nullable|string|max:150',
            'imagen_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:300',
        ]);
        // Obtener el ID de la galería
        $galeriaId = $request->galeria_id;
        if ($galeriaId == -1) {
            $galeria = new Galerias();
            $galeria->galeria_nombre = $request->galeria_nombre;
            $galerias = $galeria->save();
            // Obtener el ID de la galería guardada
            $idgaleria = $galerias->galeria_id;
        }else{
            $idgaleria = $request->galeria_id;
        }

        // Create New Equipo
        $galeriaimagen = new ImagenesGalerias();
        $galeriaimagen->galeria_id = $idgaleria;
        // Procesamiento de la imagen
        if ($request->hasFile('imagen_url')) {
            $image = $request->file('imagen_url');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = public_path('image/publicidad');
            $image->move($imagePath, $imageName); // Mueve la imagen a la carpeta de uploads/informacion
            // Actualiza el campo info_logo con el nombre de la nueva imagen
            $galeriaimagen->imagen_url = 'image/publicidad'.'/'.$imageName;
        }else {
            // Si no se proporciona ningún archivo, no realices ningún procesamiento y simplemente mantén el valor actual del campo info_logo
            $galeriaimagen->imagen_url = $galeriaimagen->imagen_url; // Asegúrate de que esto sea correcto para mantener el valor actual
        }

        $galeriaimagen->save();


        session()->flash('success', '¡¡Se ha creado los galerias!!');
        return redirect()->route('admin.galerias.index');
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
        if (is_null($this->user) || !$this->user->can('galeria.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún galeria!');
        }

        $galerias = Galerias::select('galerias.*')
                        ->where('galerias.galerias_id', '=', $id)
                        ->first();

        return view('backend.pages.galerias.edit', compact('galerias'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (is_null($this->user) || !$this->user->can('galeria.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún galeria!');
        }
        // Validación de los datos del formulario
        $request->validate([
            'galeria_nombre' => 'required|string|max:300',
        ]);
        // Obtener el registro de la base de datos
        $galeria = Galerias::find($id);
        // Actualizar los campos del registro con los datos del formulario
        $galeria->galeria_nombre = $request->galeria_nombre;

        // Guardar los cambios en la base de datos
        $galeria->save();

        // Redireccionar de vuelta con un mensaje de éxito
        session()->flash('success', '¡¡La información ha sido actualizada con éxito!!');
        return back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (is_null($this->user) || !$this->user->can('galeria.delete')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a eliminar ningún galeria!');
        }
        if ($id === 1) {
            session()->flash('error', 'Lo siento !! ¡No estás autorizado a eliminar este galeria!');
            return back();
        }

        $galerias = ImagenesGalerias::find($id);
        // Eliminar la imagen existente
        if (file_exists(public_path($galerias->imagen_url))) {
            unlink(public_path($galerias->imagen_url));
        }
        // Guardar los cambios en la base de datos
        $galerias->delete();

        session()->flash('success', '¡¡El equipo ha sido eliminado!!');
        return back();
    }
}
