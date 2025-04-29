<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UsuarioLogin;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

// use Illuminate\Support\Facades\Mail;

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
                'datos' => $user->datos
                ? [
                     ...$user->datos->toArray(),
                    'formulario' => $user->datos->formulario
                    ? $user->datos->formulario->toArray()
                    : false,
                ]
                : null,
            ],
        ], 200);
    }
    public function loginApp(Request $request)
    {
        $google = UsuarioLogin::where('google_id', $request->googleId)->first();
        if ($google) {
            return response()->json([
                'success' => true,
                'message' => 'Inicio de sesión exitoso',
                'token'   => $google->createToken('token-name')->plainTextToken,
                'user'    => [
                     ...$google->toArray(),
                    'datos' => $google->datos
                    ? [
                         ...$google->datos->toArray(),
                        'formulario' => $google->datos->formulario
                        ? $google->datos->formulario->toArray()
                        : false,
                    ]
                    : null,
                ],
            ], 200);
        }

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
                                'datos' => $user->datos
                                ? [
                                     ...$user->datos->toArray(),
                                    'formulario' => $user->datos->formulario
                                    ? $user->datos->formulario->toArray()
                                    : false,
                                ]
                                : null,
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

        if (isset($request->email) && $request->email != $user->usu_login_email) {
            $old = UsuarioLogin::where('usu_login_email', $request->email)->first();

            if ($old) {
                return response()->json([
                    'success' => false,
                    'message' => 'Correo electronico ya existente, pruebe con otro',
                    'data'    => [],
                ]);
            }
        }

        if (isset($request->username) && $request->username != $user->usu_login_username) {
            $old = UsuarioLogin::where('usu_login_email', $request->username)->first();
            if ($old) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nombre de usuario ya existente, pruebe con otro',
                    'data'    => [],
                ]);
            }
        }

        $user->usu_login_name     = $request->name ?? $user->usu_login_name;
        $user->usu_login_username = $request->username ?? $user->usu_login_username;
        if ($request->googleId == '0') {
            $user->google_id = null;
        }
        if ($user->usu_login_email != $request->email &&
            $user->google_id != null) {
            $user->google_id = null;
        } else {
            $user->google_id = $request->googleId ?? $user->google_id;
        }
        $user->usu_login_email = $request->email ?? $user->usu_login_email;

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

    public function registerUser(Request $request)
    {
        if (! $request->email) {
            return response()->json([
                'success' => false,
                'message' => 'Email requerido',
                'data'    => [],
            ]);
        }
        if (! $request->name) {
            return response()->json([
                'success' => false,
                'message' => 'Nombres requeridos',
                'data'    => [],
            ]);
        }
        if (! $request->username) {
            return response()->json([
                'success' => false,
                'message' => 'Nombre de usuario requerido',
                'data'    => [],
            ]);
        }
        if (! $request->username) {
            return response()->json([
                'success' => false,
                'message' => 'Nombre de usuario requerido',
                'data'    => [],
            ]);
        }
        if (! $request->password) {
            return response()->json([
                'success' => false,
                'message' => 'La contraseña es requerida',
                'data'    => [],
            ]);
        }

        $old = UsuarioLogin::where('usu_login_email', $request->email)->first();
        if ($old) {
            return response()->json([
                'success' => false,
                'message' => 'Correo electronico ya existente, pruebe con otro',
                'data'    => [],
            ]);
        }
        $old = UsuarioLogin::where('usu_login_email', $request->username)->first();
        if ($old) {
            return response()->json([
                'success' => false,
                'message' => 'Nombre de usuario ya existente, pruebe con otro',
                'data'    => [],
            ]);
        }

        $user                     = new UsuarioLogin();
        $user->usu_login_name     = $request->name;
        $user->usu_login_username = $request->username;
        $user->usu_login_email    = $request->email;
        $user->google_id          = $request->googleId;
        $user->usu_login_password = Hash::make($request->password);

        if ($request->hasFile('imagen')) {
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
            'message' => 'Usuario registrado correctamente.',
            'data'    => $user,
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        if (! isset($request->email)) {
            return response()->json([
                'success' => true,
                'message' => 'Email requerido',
                'data'    => [],
            ]);
        }

        $user = UsuarioLogin::where('usu_login_email', $request->email)->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Email no registrado',
                'data'    => [],
            ], 404);
        }

        $token = Str::random(64);

        // Guardar el token en password_resets
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token'      => bcrypt($token),
                'created_at' => now(),
            ]
        );

        // URL personalizada
        $url = config('app.url') . "/reset-password?token=$token&email=" . urlencode($request->email);

        // Enviar correo
        Mail::raw("Hola!\n\nHaz clic en el siguiente enlace para restablecer tu contraseña:\n$url\n\nSi no lo solicitaste, ignora este mensaje.", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Restablecer contraseña - MODO GYM');
        });

        return response()->json([
            'success' => true,
            'message' => 'Correo de recuperación enviado',
            'data'    => $url,
        ]);

    }

    public function searchGoogleId(string $id)
    {
        $google = UsuarioLogin::where('google_id', $id)->first();

        if (! $google) {
            return response()->json([
                'success' => false,
                'message' => 'Id no encontrado',
                'data'    => [],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Google existente',
            'data'    => $google,
        ]);
    }
    public function searchEmail(string $email)
    {
        $email = UsuarioLogin::where('usu_login_email', $email)->first();

        if (! $email) {
            return response()->json([
                'success' => false,
                'message' => 'Correo no encontrado',
                'data'    => [],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Correo existente',
            'data'    => $email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');

        if (! $email || ! $token) {
            return redirect()->back()->with('error', 'Enlace inválido.');
        }

        // Validación básica del token (puede ser opcional acá)
        $reset = DB::table('password_resets')->where('email', $email)->first();
        if (! $reset || ! Hash::check($token, $reset->token)) {
            return redirect()->back()->with('error', 'El enlace es inválido o expiró.');
        }

        return view('auth.passwords.reset', compact('email', 'token'));
    }
    public function postResetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'token'    => 'required',
            'password' => 'required|min:5|confirmed',
        ], [
            'email.required'     => 'El email es requerido',
            'email.email'        => 'El email es debe ser valido',
            'token.required'     => 'Sin codigo de autorización token',
            'password.required'  => 'La contraseña es requerida',
            'password.min'       => 'La contraseña debe tener al menos 5 caracteres',
            'password.confirmed' => 'Las contraseña no coinciden',
        ]);

        $reset = DB::table('password_resets')->where('email', $request->email)->first();

        if (! $reset || ! Hash::check($request->token, $reset->token)) {
            return back()->withErrors(['token' => 'Token inválido o expirado.']);
        }

        $user = UsuarioLogin::where('usu_login_email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Usuario no encontrado.']);
        }

        $user->usu_login_password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('admin.login')->with('success', 'Contraseña actualizada correctamente.');
    }
}
