<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UsuarioLogin;
use Illuminate\Support\Facades\Hash;

class LoginAppController extends Controller
{
    public function getStatus()
    {
        return response()->json([
            'success' => true,
            'message' => 'Api server running successfully'
        ], 200);
    }
    public function loginApp(Request $request)
    {
        if ($request->email) {
            if ($request->password) {
                $user = UsuarioLogin::where('usu_login_username', $request->email)->orWhere('usu_login_email', $request->email)->first();

                if ($user) {
                    if (Hash::check($request->password, $user->usu_login_password)) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Inicio de sesión exitoso',
                            'user' => [
                                ...$user->toArray(),
                                'datos' => [
                                    ...$user->datos->toArray(),
                                    'formulario' => $user->datos->formulario ? $user->datos->formulario->toArray() : false
                                ]
                            ]
                        ], 200);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Contraseña incorrecta'
                        ], 401);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Usuario inexistente'
                    ], 404);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Debe ingresar la contraseña'
                ], 400);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Debe ingresar el usuario'
            ], 400);
        }
    }
    public function getProfile($id)
    {
        $user = UsuarioLogin::where('usu_id', $id)->first();
        if ($user) {
            return response()->json([
                ...$user->toArray(),
                'formulario' => $user->datos->formulario ? $user->datos->formulario->toArray() : null
            ], 200);
        }

        return response()->json($user);
    }
}
