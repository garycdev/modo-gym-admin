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
    public function authApp(Request $request)
    {
        $user = UsuarioLogin::findOrFail($request->user()->usu_login_id);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario inexistente',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sesión iniciada',
            // 'token'   => $user->createToken('token-name')->plainTextToken,
            'user'    => [
                 ...$user->toArray(),
                'datos' => [
                     ...$user->datos->toArray(),
                    'formulario' => $user->datos->formulario ? $user->datos->formulario->toArray() : false,
                ],
            ],
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
                            'token'   => $user->createToken('token-name')->plainTextToken,
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
                                'token'   => $userNuevo->createToken('token-name')->plainTextToken,
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
    public function logoutApp(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada',
        ]);
    }
    public function getProfile(Request $request)
    {
        $user = UsuarioLogin::findOrFail($request->user()->usu_login_id);
        if ($user) {
            return response()->json([
                 ...$user->toArray(),
                'datos'      => $user->datos,
                'formulario' => $user->datos->formulario ? $user->datos->formulario->toArray() : null,
            ], 200);
        }

        return response()->json($user);
    }

    public function updatePassword(Request $request)
    {
        // return response()->json([
        //     'success' => true,
        //     'message' => 'update',
        //     'data'    => $request->user(),
        // ]);
        $user = UsuarioLogin::where('usu_login_id', $request->user()->usu_login_id)->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado',
            ], 404);
        }

        if ($request->password < 5) {
            return response()->json([
                'success' => false,
                'message' => 'La contraseña debe tener al menos 5 caracteres',
            ], 400);
        }

        $user->usu_login_password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Contraseña actualizada correctamente.',
        ], 200);
    }
    public function updateProfile(Request $request)
    {
        // return response()->json([
        //     'success' => true,
        //     'message' => 'update',
        //     'data'    => $request->hasFile('imagen'),
        //     'files'   => $request->files->all(),
        // ]);

        $user = UsuarioLogin::where('usu_login_id', $request->user()->usu_login_id)->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado',
            ], 404);
        }

        $user->usu_login_name     = $request->name ?? $user->usu_login_name;
        $user->usu_login_username = $request->username ?? $user->usu_login_username;
        $user->usu_login_email    = $request->email ?? $user->usu_login_email;
        if ($user->usu_login_email != $request->email &&
            $user->google_id != null) {
            $user->google_id = null;
        }

        if ($request->hasFile('imagen')) {
            // $datos = Usuarios::findOrFail($user->usu_id);
            // if (! $datos) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Datos del usuario no encontrado, comuniquese con el administrador',
            //     ], 400);
            // }

            $image     = $request->file('imagen');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('image/cliente');
            $image->move($imagePath, $imageName);
            $user->usu_login_imagen = 'image/cliente' . '/' . $imageName;
            // $datos->usu_imagen = 'image/cliente' . '/' . $imageName;
            // $datos->save();
        }
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Datos actualizados correctamente.',
            'data'    => $user,
        ], 200);
    }
}
