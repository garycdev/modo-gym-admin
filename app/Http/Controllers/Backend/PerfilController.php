<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\UsuarioLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    public $user;
    public $guard;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::guard('admin')->user()) {
                $this->user = Auth::guard('admin')->user();
                $this->guard = 'admin';
            } else {
                $this->user = Auth::guard('user')->user();
                $this->guard = 'user';
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user = Admin::where('')->first();
        if ($this->guard == 'admin') {
            $user = [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'username' => $this->user->username,
                'google_id' => $this->user->google_id,
                'type' => 'admin',
            ];
        } else if ($this->guard == 'user') {
            $user = [
                'id' => $this->user->usu_login_id,
                'name' => $this->user->usu_login_name,
                'email' => $this->user->usu_login_email,
                'username' => $this->user->usu_login_username,
                'google_id' => $this->user->google_id,
                'type' => 'user',
            ];
        }
        return view('backend.pages.perfil.edit', compact('user'));
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
        if (!isset($request->tipo)) {
            if ($this->guard == 'admin') {
                $request->validate([
                    'name' => 'required',
                    // 'email' => [
                    //     'required',
                    //     'email',
                    //     Rule::unique('admins', 'email')->ignore($id),
                    // ],
                    'username' => [
                        'required',
                        Rule::unique('admins', 'username')->ignore($id),
                    ],
                ]);

                Admin::where('id', $id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                ]);
            } else if ($this->guard == 'user') {
                $request->validate([
                    'name' => 'required',
                    // 'email' => [
                    //     'required',
                    //     'email',
                    //     Rule::unique('usuario_login', 'usu_login_email')->ignore($id, 'usu_login_id'),
                    // ],
                    'username' => [
                        'required',
                        Rule::unique('usuario_login', 'usu_login_username')->ignore($id, 'usu_login_id'),
                    ],
                ]);

                UsuarioLogin::where('usu_login_id', $id)->update([
                    'usu_login_name' => $request->name,
                    'usu_login_email' => $request->email,
                    'usu_login_username' => $request->username,
                ]);
            } else {
                session()->flash('error', 'No se ha seleccionado ningún tipo de usuario.');
                return back();
            }

            session()->flash('success', '¡ Datos actualizados correctamente !');
            return back();
        } else {
            $request->validate([
                'new_password' => 'required|confirmed',
                'new_password_confirmation' => 'required',
            ]);

            if ($this->guard == 'admin') {
                Admin::where('id', $id)->update([
                    'password' => Hash::make($request->new_password),
                ]);

                Auth::guard('admin')->logout();
            } else if ($this->guard == 'user') {
                UsuarioLogin::where('usu_login_id', $id)->update([
                    'usu_login_password' => Hash::make($request->new_password),
                ]);

                Auth::guard('user')->logout();
            } else {
                session()->flash('error', 'No se ha seleccionado ningún tipo de usuario.');
                return back();
            }

            session()->flash('success', '¡ La contraseña a sido actualizada correctamente !');
            return redirect()->route('admin.login');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
