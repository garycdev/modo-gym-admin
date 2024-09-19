<?php

namespace App\Http\Controllers\Backend;


use App\Models\Blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class BlogsController extends Controller
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
        if (is_null($this->user) || !$this->user->can('blog.view')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a ver ningún blogs!');
        }

        $blogs = Blogs::where('blog_estado', '!=', 'ELIMINADO')->get();
        return view('backend.pages.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('blog.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún blog!');
        }
        return view('backend.pages.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('blog.create')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a crear ningún blog!');
        }

        // Validation Data
        $request->validate([
            'blog_titulo' => 'required|string|max:150',
            'blog_imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:100',
            'blog_descripcion' => 'nullable|string|max:50000',
        ]);
        // Create New blog
        $blog = new Blogs();
        $blog->blog_titulo = $request->blog_titulo;
        $blog->blog_descripcion = $request->blog_descripcion;
        // Procesamiento de la imagen
        if ($request->hasFile('blog_imagen')) {
            // Eliminar la imagen existente
            // if (file_exists(public_path($blog->blog_imagen))) {
            //     unlink(public_path($blog->blog_imagen));
            // }
            $image = $request->file('blog_imagen');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = public_path('image/publicidad');
            $image->move($imagePath, $imageName); // Mueve la imagen a la carpeta de uploads/informacion
            // Actualiza el campo info_logo con el nombre de la nueva imagen
            $blog->blog_imagen = 'image/publicidad'.'/'.$imageName;
        }else {
            // Si no se proporciona ningún archivo, no realices ningún procesamiento y simplemente mantén el valor actual del campo info_logo
            $blog->blog_imagen = $blog->blog_imagen; // Asegúrate de que esto sea correcto para mantener el valor actual
        }

        $blog->save();


        session()->flash('success', '¡¡Se ha creado los blogs!!');
        return redirect()->route('admin.blogs.index');
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
        if (is_null($this->user) || !$this->user->can('blog.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún blog!');
        }

        $blog = Blogs::find($id);
        return view('backend.pages.blogs.edit', compact('blog'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (is_null($this->user) || !$this->user->can('blog.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningún blog!');
        }
        // Validación de los datos del formulario
        $request->validate([
            'blog_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:100', // Validación de la imagen
            'blog_titulo' => 'required|max:255',
            'blog_descripcion' => 'required|string',
            'blog_estado' => 'required|string|max:20'
        ]);
        // Obtener el registro de la base de datos
        $blogs = Blogs::find($id);
        // Actualizar los campos del registro con los datos del formulario
        $blogs->blog_titulo = $request->blog_titulo;
        $blogs->blog_estado = $request->blog_estado;

        // Procesamiento de la imagen
        if ($request->hasFile('blog_imagen')) {
            // Eliminar la imagen existente
            if (file_exists(public_path($blogs->blog_imagen))) {
                unlink(public_path($blogs->blog_imagen));
            }
            $image = $request->file('blog_imagen');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = public_path('image/pulicidad');
            $image->move($imagePath, $imageName); // Mueve la imagen a la carpeta de uploads/informacion
            // Actualiza el campo blog_imagen con el nombre de la nueva imagen
            $blogs->blog_imagen = 'image/pulicidad'.'/'.$imageName;
        }else {
            // Si no se proporciona ningún archivo, no realices ningún procesamiento y simplemente mantén el valor actual del campo info_logo
            $blogs->blog_imagen = $blogs->blog_imagen; // Asegúrate de que esto sea correcto para mantener el valor actual
        }

        // Guardar los cambios en la base de datos
        $blogs->save();

        // Redireccionar de vuelta con un mensaje de éxito
        session()->flash('success', '¡¡La información ha sido actualizada con éxito!!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (is_null($this->user) || !$this->user->can('blog.delete')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a eliminar ningún blog!');
        }
        if ($id === 1) {
            session()->flash('error', 'Lo siento !! ¡No estás autorizado a eliminar este blog!');
            return back();
        }

        $blogs = Blogs::find($id);
        // Eliminar la imagen existente
        if (file_exists(public_path($blogs->blog_imagen))) {
            unlink(public_path($blogs->blog_imagen));
        }
        $blogs->blog_estado = 'ELIMINADO';
        // Guardar los cambios en la base de datos
        $blogs->save();

        session()->flash('success', '¡¡El blog ha sido eliminado!!');
        return back();
    }
}
