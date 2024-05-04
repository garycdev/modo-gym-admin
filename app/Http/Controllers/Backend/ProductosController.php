<?php

namespace App\Http\Controllers\Backend;


use App\Models\Productos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProductosController extends Controller
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
        if (is_null($this->user) || !$this->user->can('producto.view')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a ver ningún productos!');
        }

        $productos = Productos::where('producto_estado', '!=', 'ELIMINADO')->get();
        return view('backend.pages.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('producto.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún producto!');
        }
        return view('backend.pages.productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('producto.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún producto!');
        }

        // Validation Data
        $request->validate([
            'producto_nombre' => 'required|string|max:150',
            'producto_imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:100',
            'producto_descripcion' => 'nullable|string|max:50000',
            'producto_precio' => 'required|numeric|max:100',
            'producto_cantidad' => 'required|integer|max:100',
        ]);
        // Create New producto
        $producto = new Productos();
        $producto->producto_nombre = $request->producto_nombre;
        $producto->producto_descripcion = $request->producto_descripcion;
        $producto->producto_precio = $request->producto_precio;
        $producto->producto_cantidad = $request->producto_cantidad;
        // Procesamiento de la imagen
        if ($request->hasFile('producto_imagen')) {
            // Eliminar la imagen existente
            // if (file_exists(public_path($producto->producto_imagen))) {
            //     unlink(public_path($producto->producto_imagen));
            // }
            $image = $request->file('producto_imagen');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = public_path('image/publicidad');
            $image->move($imagePath, $imageName); // Mueve la imagen a la carpeta de uploads/informacion
            // Actualiza el campo info_logo con el nombre de la nueva imagen
            $producto->producto_imagen = 'image/publicidad'.'/'.$imageName;
        }else {
            // Si no se proporciona ningún archivo, no realices ningún procesamiento y simplemente mantén el valor actual del campo info_logo
            $producto->producto_imagen = $producto->producto_imagen; // Asegúrate de que esto sea correcto para mantener el valor actual
        }

        $producto->save();


        session()->flash('success', '¡¡Se ha creado los productos!!');
        return redirect()->route('admin.productos.index');
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
        if (is_null($this->user) || !$this->user->can('producto.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún producto!');
        }

        $producto = productos::find($id);
        return view('backend.pages.productos.edit', compact('producto'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (is_null($this->user) || !$this->user->can('producto.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún producto!');
        }
        // Validation Data
        $request->validate([
            'producto_nombre' => 'required|string|max:150',
            'producto_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:100',
            'producto_descripcion' => 'nullable|string|max:50000',
            'producto_precio' => 'required|numeric|max:100',
            'producto_cantidad' => 'required|integer|max:100',
            'producto_estado' => 'required|string|max:100',
        ]);
        // Obtener el registro de la base de datos
        $productos = productos::find($id);
        // Actualizar los campos del registro con los datos del formulario
        $productos->producto_nombre = $request->producto_nombre;
        $productos->producto_descripcion = $request->producto_descripcion;
        $productos->producto_precio = $request->producto_precio;
        $productos->producto_cantidad = $request->producto_cantidad;
        $productos->producto_estado = $request->producto_estado;

        // Procesamiento de la imagen
        if ($request->hasFile('producto_imagen')) {
            // Eliminar la imagen existente
            if (file_exists(public_path($productos->producto_imagen))) {
                unlink(public_path($productos->producto_imagen));
            }
            $image = $request->file('producto_imagen');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = public_path('image/pulicidad');
            $image->move($imagePath, $imageName); // Mueve la imagen a la carpeta de uploads/informacion
            // Actualiza el campo producto_imagen con el nombre de la nueva imagen
            $productos->producto_imagen = 'image/pulicidad'.'/'.$imageName;
        }else {
            // Si no se proporciona ningún archivo, no realices ningún procesamiento y simplemente mantén el valor actual del campo info_logo
            $productos->producto_imagen = $productos->producto_imagen; // Asegúrate de que esto sea correcto para mantener el valor actual
        }

        // Guardar los cambios en la base de datos
        $productos->save();

        // Redireccionar de vuelta con un mensaje de éxito
        session()->flash('success', '¡¡La información ha sido actualizada con éxito!!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (is_null($this->user) || !$this->user->can('producto.delete')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a eliminar ningún producto!');
        }
        if ($id === 1) {
            session()->flash('error', 'Lo siento !! ¡No estás autorizado a eliminar este producto!');
            return back();
        }

        $productos = Productos::find($id);
        // Eliminar la imagen existente
        if (file_exists(public_path($productos->producto_imagen))) {
            unlink(public_path($productos->producto_imagen));
        }
        $productos->producto_estado = 'ELIMINADO';
        // Guardar los cambios en la base de datos
        $productos->save();

        session()->flash('success', '¡¡El producto ha sido eliminado!!');
        return back();
    }
}
