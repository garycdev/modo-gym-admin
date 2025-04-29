<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BlogRutina;
use App\Models\Blogs;
use App\Models\Like;
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

        foreach ($blogs as $key => $blog) {
            // if (! is_null($blog->ejercicios)) {
            //     $ejercicios = [];

            //     $ejerData = $blog->ejercicios;
            //     if (is_string($ejerData)) {
            //         $ejerData = json_decode($ejerData, true);
            //     }

            //     if (is_array($ejerData)) {
            //         foreach ($ejerData as $ejer_id) {
            //             $ejercicio = Ejercicios::where('ejer_id', $ejer_id)->first();
            //             if ($ejercicio) {
            //                 $ejercicios[] = $ejercicio;
            //             }
            //         }
            //     }

            //     $blogs[$key]['ejercicios'] = $ejercicios;
            // }
            $ejercicios = BlogRutina::join('ejercicios as e', 'blogs_rutina.ejer_id', '=', 'e.ejer_id')
                ->where('blog_id', $blog->blog_id)
                ->get();
            $blogs[$key]['ejercicios'] = $ejercicios;

            $likes                = Like::where('blog_id', $blog->blog_id)->get();
            $blogs[$key]['likes'] = $likes;
        }

        return response()->json([
            'success' => true,
            'message' => 'Blogs',
            'data'    => $blogs,
        ], 200);
    }
    public function show(Request $request, $id)
    {
        $blogs = Blogs::where('blog_estado', '=', 'ACTIVO')
            ->where('usu_id', '=', $request->user()->usu_login_id)
            ->orderBy('blog_id', 'DESC')
            ->get();

        foreach ($blogs as $key => $blog) {
            // if (! is_null($blog->ejercicios)) {
            //     $ejercicios = [];

            //     $ejerData = $blog->ejercicios;
            //     if (is_string($ejerData)) {
            //         $ejerData = json_decode($ejerData, true);
            //     }

            //     if (is_array($ejerData)) {
            //         foreach ($ejerData as $ejer_id) {
            //             $ejercicio = Ejercicios::where('ejer_id', $ejer_id)->first();
            //             if ($ejercicio) {
            //                 $ejercicios[] = $ejercicio;
            //             }
            //         }
            //     }

            //     $blogs[$key]['ejercicios'] = $ejercicios;
            // }
            $ejercicios = BlogRutina::join('ejercicios as e', 'blogs_rutina.ejer_id', '=', 'e.ejer_id')
                ->where('blog_id', $blog->blog_id)
                ->get();
            $blogs[$key]['ejercicios'] = $ejercicios;

            $likes                = Like::where('blog_id', $blog->blog_id)->get();
            $blogs[$key]['likes'] = $likes;
        }

        return response()->json([
            'success' => true,
            'message' => 'Blogs de usuario ' . $id,
            'data'    => $blogs,
        ], 200);
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        // if (! empty($request->values)) {
        //     $values = is_string($request->values) ? json_decode($request->values, true) : $request->values;

        //     foreach ($values as $key => $value) {
        //         [$id1, $id2] = explode('-', $key); // Separa los IDs

        //         $serie = Rutinas::where('rut_id', $id2)->where('ejer_id', $id1)->first();
        //         if ($serie) {
        //             $serie->estado = $value;
        //             $serie->save();
        //         }
        //     }
        // } else {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Ninguna serie completada',
        //     ], 400);
        // }

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
        $blog->tiempo      = $request->segundos;
        $fecha             = Carbon::createFromFormat('Y-m-d\TH:i:s.u', $request->fecha)->format('Y-m-d H:i:s');
        $blog->fecha       = $fecha;
        $blog->usu_id      = $request->user()->usu_login_id;
        $blog->visibilidad = $request->visibilidad;
        $blog->save();

        $ejersIds = json_decode($request->input('ejers_id'), true);
        $counts   = array_count_values($ejersIds);
        foreach ($counts as $id => $series) {
            BlogRutina::create([
                'blog_id' => $blog->blog_id,
                'ejer_id' => $id,
                'series'  => $series,
            ]);
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
        $blog = Blogs::findOrFail($id);
        if (! $blog) {
            return response()->json([
                'success' => false,
                'message' => 'Blog no encontrado',
            ], 404);
        }
        $blog->visibilidad = $request->visibilidad ?? $blog->visibilidad;
        $blog->save();

        return response()->json([
            'success' => true,
            'message' => 'Blog actualizado con éxito',
            'blog'    => $blog,
        ], 200);
    }
    public function destroy(string $id)
    {
        $blog = Blogs::findOrFail($id);
        if (! $blog) {
            return response()->json([
                'success' => false,
                'message' => 'Blog no encontrado',
            ], 404);
        }
        $blog->blog_estado = 'ELIMINADO';
        $blog->save();

        return response()->json([
            'success' => true,
            'message' => 'Blog eliminado con éxito',
            'blog'    => $blog,
        ], 200);
    }
}
