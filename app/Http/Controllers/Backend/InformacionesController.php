<?php

namespace App\Http\Controllers\Backend;

use App\Models\InformacionEmpresa;
use App\Models\Costos;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;




class InformacionesController extends Controller
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
        if (is_null($this->user) || !$this->user->can('informacion_empresa.view')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a ver ningún rol!');
        }

        $costos = Costos::all();
        $informacionempresa = InformacionEmpresa::first();
        return view('backend.pages.informaciones.index', compact('informacionempresa', 'costos'));
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
        //
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
        if (is_null($this->user) || !$this->user->can('informacion_empresa.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningúna información!');
        }
        // if ($id === 1) {
        //     session()->flash('error', 'Lo siento !! No está autorizado a actualizar este administrador ya que es el superadministrador. ¡Cree uno nuevo si necesita realizar una prueba!');
        //     return back();
        // }
        // Validación de los datos del formulario
        $request->validate([
            'info_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen
            'info_nombre' => 'string|max:255',
            'info_descripcion' => 'nullable|string',
            'info_sobre_nosotros' => 'nullable|string',
            'info_video_url' => 'nullable|string|url',
            'info_telefono_1' => 'nullable|string|max:20',
            'info_contacto_1' => 'nullable|string|max:20',
            'info_contacto_2' => 'nullable|string|max:20',
            'info_contacto_3' => 'nullable|string|max:20',
            'info_atencion' => 'nullable|string',
            'info_correo' => 'nullable|email|max:255',
            'info_facebook' => 'nullable|string|max:255',
            'info_tiktok' => 'nullable|string|max:255',
            'info_ano_experiencia' => 'nullable|integer|min:0',
            'info_whatsapp' => 'nullable|string|max:20',
            'info_pagina' => 'nullable|string|url',
            'info_mapa' => 'nullable|string|url',
            'info_latitud' => 'nullable|string',
            'info_longitud' => 'nullable|string',
            'info_direccion' => 'nullable|string|max:255',
        ]);
        // Obtener el registro de la base de datos
        $informacionempresa = InformacionEmpresa::find($id);
        // Actualizar los campos del registro con los datos del formulario
        $informacionempresa->info_nombre = $request->info_nombre;
        $informacionempresa->info_descripcion = $request->info_descripcion ?? null;
        $informacionempresa->info_sobre_nosotros = $request->info_sobre_nosotros ?? null;
        $informacionempresa->info_video_url = $request->info_video_url ?? null;
        $informacionempresa->info_telefono_1 = $request->info_telefono_1 ?? null;
        $informacionempresa->info_contacto_1 = $request->info_contacto_1 ?? null;
        $informacionempresa->info_contacto_2 = $request->info_contacto_2 ?? null;
        $informacionempresa->info_contacto_3 = $request->info_contacto_3 ?? null;
        $informacionempresa->info_atencion = $request->info_atencion ?? null;
        $informacionempresa->info_correo = $request->info_correo ?? null;
        $informacionempresa->info_facebook = $request->info_facebook ?? null;
        $informacionempresa->info_tiktok = $request->info_tiktok ?? null;
        $informacionempresa->info_ano_experiencia = $request->info_ano_experiencia ?? null;
        $informacionempresa->info_whatsapp = $request->info_whatsapp ?? null;
        $informacionempresa->info_pagina = $request->info_pagina ?? null;
        $informacionempresa->info_mapa = $request->info_mapa ?? null;
        $informacionempresa->info_latitud = $request->info_latitud ?? null;
        $informacionempresa->info_longitud = $request->info_longitud ?? null;
        $informacionempresa->info_direccion = $request->info_direccion ?? null;
        $informacionempresa->info_updated_at = now();

        // Procesamiento de la imagen
        if ($request->hasFile('info_logo')) {
            // Eliminar la imagen existente
            if (file_exists(public_path($informacionempresa->info_logo))) {
                unlink(public_path($informacionempresa->info_logo));
            }
            $image = $request->file('info_logo');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = public_path('image/modo-gym');
            $image->move($imagePath, $imageName); // Mueve la imagen a la carpeta de uploads/informacion
            // Actualiza el campo info_logo con el nombre de la nueva imagen
            $informacionempresa->info_logo = 'image/modo-gym'.'/'.$imageName;
        }else {
            // Si no se proporciona ningún archivo, no realices ningún procesamiento y simplemente mantén el valor actual del campo info_logo
            $informacionempresa->info_logo = $informacionempresa->info_logo; // Asegúrate de que esto sea correcto para mantener el valor actual
        }

        // Guardar los cambios en la base de datos
        $informacionempresa->save();

        // Redireccionar de vuelta con un mensaje de éxito
        session()->flash('success', '¡¡La información ha sido actualizada con éxito!!');
        return back();
    }


    public function updatec(Request $request, string $id)
    {
        if (is_null($this->user) || !$this->user->can('costo.edit')) {
            abort(403, 'Lo siento !! ¡No estás autorizado a editar ningúna información!');
        }
        if ($id === 1) {
            session()->flash('error', 'Lo siento !! No está autorizado a actualizar este administrador ya que es el superadministrador. ¡Cree uno nuevo si necesita realizar una prueba!');
            return back();
        }

        $request->validate([
            'monto' => 'nullable|numeric|min:0',
        ]);
        // Obtener el registro de la base de datos
        $costo = Costos::find($id);
        // Actualizar los campos del registro con los datos del formulario
        $costo->monto = $request->monto;
        // Guardar los cambios en la base de datos
        $costo->save();
        // Redireccionar de vuelta con un mensaje de éxito
        session()->flash('success', '¡¡La información ha sido actualizada con éxito!!');
        return back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
