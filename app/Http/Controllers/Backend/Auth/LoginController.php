<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pagos;
use App\Models\UsuarioLogin;
use App\Models\Usuarios;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        if (Auth::guard('admin')->check()) {
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
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember) ||
            Auth::guard('admin')->attempt(['username' => $request->email, 'password' => $request->password], $request->remember)) {

            // Redirect to dashboard
            session()->flash('success', 'Sesión iniciada con exito !');
            return redirect()->route('admin.dashboard');
        } else {
            $user = UsuarioLogin::where('usu_login_email', $request->email)->orWhere('usu_login_username', $request->email)->first();
            if ($user && Hash::check($request->password, $user->usu_login_password)) {
                $pagos = Pagos::where('usu_id', $user->usu_id)->count();
                if ($pagos > 0) {
                    Auth::guard('user')->login($user);

                    // Redirect to dashboard
                    session()->flash('success', 'Sesión iniciada con exito !');
                    return redirect()->route('admin.dashboard');
                } else {
                    session()->flash('error', 'Cuenta inactiva ¡ No existen pagos para el usuario !');
                    return back();
                }
            } else {
                $user_guest = Usuarios::where('usu_ci', $request->email)->first();
                if ($user_guest) {
                    $pagos = Pagos::where('usu_id', $user_guest->usu_id)->count();
                    if ($pagos > 0) {
                        $names = explode(' ', trim($user_guest->usu_nombre));
                        $name = array_filter($names);
                        $firstName = reset($name);
                        if (strtoupper($firstName) . '_' . $user_guest->usu_ci == $request->password) {
                            // dd($user_guest);

                            $nuevo = new UsuarioLogin();
                            $nuevo->usu_login_name = $user_guest->usu_nombre . ' ' . $user_guest->usu_apellidos;
                            $nuevo->usu_login_email = $user_guest->usu_email;
                            $nuevo->usu_login_username = $user_guest->usu_ci;
                            $nuevo->usu_login_password = Hash::make($request->password);
                            $nuevo->usu_id = $user_guest->usu_id;
                            $nuevo->save();

                            $userNuevo = UsuarioLogin::where('usu_login_email', $user_guest->usu_email)->orWhere('usu_login_username', $user_guest->usu_ci)->first();
                            $userNuevo->assignRole('usuario');

                            Auth::guard('user')->login($userNuevo);

                            // Redirect to dashboard
                            session()->flash('success', 'Usuario creado ¡¡ Por favor, cambie su contraseña !!');
                            return redirect()->route('admin.dashboard');
                        }
                    } else {
                        session()->flash('error', '¡ No existen pagos para el usuario !');
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
        return redirect()->route('admin.login');
    }
}
