<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use App\Models\Rutinas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    public function index()
    {
        $blogs = Blogs::where('blog_estado', '=', 'ACTIVO')
            ->where('visibilidad', '=', 'public')
            ->orderBy('blog_id', 'DESC')
            ->get();

        return response()->json($blogs, 200);
    }
    public function blogsAppUser($id)
    {
        $blogs = Blogs::where('blog_estado', '=', 'ACTIVO')
            ->where('usu_id', '=', $id)
            ->orderBy('blog_id', 'DESC')
            ->get();

        return response()->json($blogs, 200);
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $blog                   = new Blogs();
        $blog->blog_titulo      = $request->titulo;
        $blog->blog_descripcion = $request->descripcion;
        if ($request->hasFile('imagen')) {
            $image     = $request->file('imagen');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('image/publicidad');
            $image->move($imagePath, $imageName);
            $blog->blog_imagen = 'image/publicidad' . '/' . $imageName;
        }
        $blog->tiempo = $request->segundos;

        $fecha             = Carbon::parse($request->fecha);
        $blog->fecha       = $fecha->format('d/m/Y H:i:s');
        $blog->usu_id      = $request->usu_id;
        $blog->visibilidad = $request->visibilidad;
        $blog->save();

        foreach ($request->values as $key => $value) {
            [$id1, $id2] = explode('-', $key);

            $serie = Rutinas::where('rut_id', $id2)->where('ejer_id', $id1)->first();
            $serie->estado = $value;
            $serie->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Blog creado con éxito',
            'blog'    => $blog,
        ], 201);
    }
    public function edit(string $id)
    {
        //
    }
    public function update(Request $request, string $id)
    {
        //
    }
    public function destroy(string $id)
    {
        //
    }
}
