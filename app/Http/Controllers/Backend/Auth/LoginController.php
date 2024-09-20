<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\UsuarioLogin;
use App\Models\Usuarios;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN_DASHBOARD;

    /**
     * show login form for admin guard
     *
     * @return void
     */
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check() || Auth::guard('user')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('backend.auth.login');
    }

    /**
     * login admin
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        // Validate Login Data
        $request->validate([
            'email' => 'required|max:50',
            'password' => 'required',
        ]);

        // if (isset($request->remember) && $request->remember == 'on') {
        //     Cookie::queue(Cookie::make('remember', , 43200));
        // }

        // Attempt to login with email or username
        if (
            Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember) ||
            Auth::guard('admin')->attempt(['username' => $request->email, 'password' => $request->password], $request->remember)
        ) {

            // Redirect to dashboard
            session()->flash('success', 'Sesión iniciada con exito !');
            return redirect()->route('admin.dashboard');
        } else {
            // Verificar si usuario cliente existe
            $user = UsuarioLogin::where('usu_login_username', $request->email)->orWhere('usu_login_email', $request->email)->first();
            // dd($user);
            if ($user) {
                // Si existe
                if (Hash::check($request->password, $user->usu_login_password)) {
                    if ($this->verificarPagos($user->usu_id)) {
                        Auth::guard('user')->login($user, $request->remember);

                        // Redirect to dashboard
                        session()->flash('success', 'Sesión iniciada con exito !');
                        session()->flash('formulario', $user->formulario);
                        return redirect()->route('admin.dashboard');
                    } else {
                        return back();
                    }
                } else {
                    session()->flash('error', 'Nombre de usuario o contraseña invalida !');
                    return back();
                }
            } else {
                $user_guest = Usuarios::validarSesion($request->email, $request->password);
                // dd($user_guest);
                if ($user_guest) {
                    $user_log = UsuarioLogin::where('usu_id', $user_guest->usu_id)->first();
                    // dd($user_log);
                    if (!$user_log) {
                        if ($this->verificarPagos($user_guest->usu_id)) {
                            $nuevo = new UsuarioLogin();
                            $nuevo->usu_login_name = $user_guest->usu_nombre;
                            $nuevo->usu_login_email = $user_guest->usu_email;
                            $nuevo->usu_login_username = $user_guest->usu_ci;
                            $nuevo->usu_login_password = Hash::make($request->password);
                            $nuevo->usu_id = $user_guest->usu_id;
                            $nuevo->save();

                            $userNuevo = UsuarioLogin::where('usu_id', $user_guest->usu_id)->where('usu_login_username', $user_guest->usu_ci)->first();
                            $userNuevo->assignRole('usuario');

                            Auth::guard('user')->login($userNuevo, $request->remember);

                            // Redirect to dashboard
                            session()->flash('info', 'Usuario creado ¡¡ Por favor, cambie sus datos y contraseña !!');
                            session()->flash('formulario', 0);
                            // return redirect()->route('admin.perfil.index');
                            return redirect()->route('admin.dashboard');
                        } else {
                            return back();
                        }
                    } else {
                        session()->flash('error', 'El usuario ya se encuentra registrado, inicie sesión con sus credenciales !');
                        return back();
                    }
                }
                session()->flash('error', 'Nombre de usuario o contraseña invalida !');
                return back();
            }
            session()->flash('error', 'Nombre de usuario o contraseña invalida !');
            return back();
        }
    }

    /**
     * logout admin guard
     *
     * @return void
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        Auth::guard('user')->logout();
        return redirect()->route('admin.login');
    }

    public function redirect()
    {
        /** @var \Laravel\Socialite\Two\AbstractProvider $socialite */
        $socialite = Socialite::driver('google');
        return $socialite->with(['prompt' => 'select_account'])->redirect();
    }

    public function callback()
    {
        $google_user = Socialite::driver('google')->user();
        // $user->token
        // dd($google_user);
        $user_admin = Admin::where('email', $google_user->email)->first();
        if ($user_admin) {
            if (!$user_admin->google_id) {
                $user_admin->google_id = $google_user->id;
                $user_admin->save();
            } else if ($user_admin->google_id != $google_user->id) {
                session()->flash('error', '¡ Error al iniciar sesión !');
                return redirect()->route('admin.dashboard');
            }
            Auth::guard('admin')->login($user_admin);

            // Redirect to dashboard
            session()->flash('success', 'Sesión iniciada con exito !');
            return redirect()->route('admin.dashboard');
        } else {
            $user = UsuarioLogin::where('usu_login_email', $google_user->email)->first();
            if ($user) {
                if ($this->verificarPagos($user->usu_id)) {
                    if (!$user->google_id) {
                        $user->google_id = $google_user->id;
                        $user->save();
                    } else if ($user->google_id != $google_user->id) {
                        session()->flash('error', '¡ Error al iniciar sesión !');
                        return redirect()->route('admin.dashboard');
                    }

                    Auth::guard('user')->login($user);

                    // Redirect to dashboard
                    session()->flash('success', 'Sesión iniciada con exito !');
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->route('admin.login');
                }
            } else {
                session()->flash('error', '¡ Correo no vinculado en el sistema !');
                return redirect()->route('admin.login');
            }
        }
    }

    public function verificarPagos($usu_id)
    {
        $pagos = DB::table('usuarios')
            ->join('pagos', 'usuarios.usu_id', '=', 'pagos.usu_id')
            ->join('costos', 'pagos.costo_id', '=', 'costos.costo_id')
            ->where('usuarios.usu_id', $usu_id)
            ->orderBy('pagos.actualizado_en', 'desc')
            ->select('costos.*', 'pagos.pago_fecha')
            ->first();

        if ($pagos) {
            $fechaPago = new \DateTime($pagos->pago_fecha);
            $fechaLimite = clone $fechaPago;
            $fechaLimite->modify('+' . ($pagos->mes * 30) . ' days');
            $fechaActual = today();
            $diff = $fechaActual->diff($fechaLimite);
            $diferenciaDias = $diff->format('%r%a');
            if (intval($diferenciaDias) < 0) {
                session()->flash('error', 'Cuenta inactiva. ¡ No se encontró un pago actual para este usuario !');
                return false;
            } elseif (intval($diferenciaDias) > 30) {
                session()->flash('error', 'Cuenta inactiva. ¡ Aun no inicia su mensualidad !');
                return false;
            } else {
                return true;
            }
        } else {
            session()->flash('error', '¡ No existen pagos para el usuario !');
            return false;
        }
    }

    public function unlink(Request $request)
    {
        if ($request->type == 'admin') {
            Admin::where('google_id', $request->google_id)->update([
                'email' => null,
                'google_id' => null,
            ]);
        } else if ($request->type == 'user') {
            UsuarioLogin::where('google_id', $request->google_id)->update([
                'usu_login_email' => null,
                'google_id' => null,
            ]);
        }

        session()->flash('success', '¡ Google desvinculado satisfactoriamente !');
        return redirect()->route('admin.perfil.index');
    }
}
