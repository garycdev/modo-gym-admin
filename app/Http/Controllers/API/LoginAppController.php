<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UsuarioLogin;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginAppController extends Controller
{
    public function getStatus()
    {
        return response()->json([
            'success' => true,
            'message' => 'Api server running successfully',
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
                            'user'    => [
                                 ...$user->toArray(),
                                'datos' => [
                                     ...$user->datos->toArray(),
                                    'formulario' => $user->datos->formulario ? $user->datos->formulario->toArray() : false,
                                ],
                            ],
                        ], 200);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Contraseña incorrecta',
                        ], 401);
                    }
                } else {
                    $user_guest = Usuarios::validarSesion($request->email, $request->password);
                    // dd($user_guest);
                    if ($user_guest) {
                        $user_log = UsuarioLogin::where('usu_id', $user_guest->usu_id)->first();
                        // dd($user_log);
                        if (! $user_log) {
                            // if ($this->verificarPagos($user_guest->usu_id)) {
                            $nuevo                     = new UsuarioLogin();
                            $nuevo->usu_login_name     = $user_guest->usu_nombre;
                            $nuevo->usu_login_email    = $user_guest->usu_email;
                            $nuevo->usu_login_username = $user_guest->usu_ci;
                            $nuevo->usu_login_password = Hash::make($request->password);
                            $nuevo->usu_id             = $user_guest->usu_id;
                            $nuevo->save();

                            $userNuevo = UsuarioLogin::where('usu_id', $user_guest->usu_id)->where('usu_login_username', $user_guest->usu_ci)->first();
                            $userNuevo->assignRole('usuario');

                            // Auth::guard('user')->login($userNuevo, $request->remember);

                            return response()->json([
                                'success' => true,
                                'message' => 'Usuario creado ¡¡ Por favor, cambie sus datos y contraseña !!',
                                'user'    => [
                                     ...$userNuevo->toArray(),
                                    'datos' => [
                                         ...$userNuevo->datos->toArray(),
                                        'formulario' => $userNuevo->datos->formulario ? $userNuevo->datos->formulario->toArray() : false,
                                    ],
                                ],
                            ], 200);
                        } else {
                            return response()->json([
                                'success' => false,
                                'message' => 'El usuario ya se encuentra registrado, inicie sesión con sus credenciales !',
                            ], 401);
                        }
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Usuario inexistente',
                        ], 404);
                    }
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Debe ingresar la contraseña',
                ], 400);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Debe ingresar el usuario',
            ], 400);
        }
    }
    public function getProfile($id)
    {
        $user = UsuarioLogin::where('usu_id', $id)->first();
        if ($user) {
            return response()->json([
                 ...$user->toArray(),
                'datos'      => $user->datos,
                'formulario' => $user->datos->formulario ? $user->datos->formulario->toArray() : null,
            ], 200);
        }

        return response()->json($user);
    }

    public function updatePassword(Request $request, string $id)
    {
        if (! $request->username) {
            return response()->json([
                'success' => false,
                'message' => 'El nombre de usuario es requerido',
            ], 400);
        }
        if (! $request->password) {
            return response()->json([
                'success' => false,
                'message' => 'La contraseña es requerido',
            ], 400);
        }

        if (strlen($request->username) < 4) {
            return response()->json([
                'success' => false,
                'message' => 'El nombre de usuario debe tener al menos 4 caracteres',
            ], 400);
        }
        if (strlen($request->password) < 5) {
            return response()->json([
                'success' => false,
                'message' => 'La contraseña debe tener al menos 5 caracteres',
            ], 400);
        }

        $old = UsuarioLogin::where('usu_login_username', $request->username)
            ->where('usu_id', '<>', $id)
            ->first();

        if ($old) {
            return response()->json([
                'success' => false,
                'message' => 'El nombre de usuario ya existe',
            ], 400);
        }

        $user = UsuarioLogin::where('usu_id', $id)->first();

        if ($user) {
            $user->usu_login_username = $request->username ?? $user->usu_login_username;
            $user->usu_login_password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Contraseña actualizada exitosamente',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Usuario no encontrado',
        ], 404);
    }
}
