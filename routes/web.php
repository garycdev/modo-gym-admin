<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    // MODO GYM
    Route::resource('informaciones', 'Backend\InformacionesController', ['names' => 'admin.informaciones']);
    Route::put('informaciones/{informacion}/updatec', 'Backend\InformacionesController@updatec')->name('admin.informaciones.updatec');

    Route::resource('ejercicios', 'Backend\EjerciciosController', ['names' => 'admin.ejercicios']);
    Route::resource('equipos', 'Backend\EquiposController', ['names' => 'admin.equipos']);
    Route::resource('musculos', 'Backend\MusculosController', ['names' => 'admin.musculos']);
    Route::resource('rutinas', 'Backend\RutinasController', ['names' => 'admin.rutinas']);
    Route::get('usuario/rutinas/{usu_id}', 'Backend\RutinasController@usuarioRutinas')->name('admin.usuario.rutinas');
    Route::post('rutinas/store', 'Backend\RutinasController@storeRutinas')->name('admin.rutinas.storeRutinas');
    Route::post('rutinas/guardar', 'Backend\RutinasController@guardarRutina')->name('admin.rutinas.guardar');
    Route::post('rutinas/eliminar', 'Backend\RutinasController@eliminarRutina')->name('admin.rutinas.eliminar');
    // Route::get('usuario/rutinas/{usu_id}/{dia}', 'Backend\RutinasController@usuarioRutinasDia')->name('admin.usuario.rutinas.dia');

    Route::resource('predeterminadas', 'Backend\DefectoController', ['names' => 'admin.defecto']);
    Route::resource('rutinas-def', 'Backend\RutinasDefectoController', ['names' => 'admin.rutinas-def']);
    Route::post('rutinas-def/guardar', 'Backend\RutinasDefectoController@guardarRutina')->name('admin.rutinas-def.guardar');
    Route::post('rutinas-def/eliminar', 'Backend\RutinasDefectoController@eliminarRutina')->name('admin.rutinas-def.eliminar');

    Route::resource('blogs', 'Backend\BlogsController', ['names' => 'admin.blogs']);
    Route::resource('productos', 'Backend\ProductosController', ['names' => 'admin.productos']);
    Route::resource('galerias', 'Backend\GaleriasController', ['names' => 'admin.galerias']);
    Route::resource('videos', 'Backend\VideosController', ['names' => 'admin.videos']);
    Route::resource('clientes', 'Backend\ClientesController', ['names' => 'admin.clientes']);
    Route::resource('costos', 'Backend\CostosController', ['names' => 'admin.costos']);
    Route::resource('pagos', 'Backend\PagosController', ['names' => 'admin.pagos']);
    Route::resource('citas', 'Backend\CitasController', ['names' => 'admin.citas']);
    Route::resource('horarios', 'Backend\HorariosController', ['names' => 'admin.horarios']);
    Route::resource('contactos', 'Backend\ContactosController', ['names' => 'admin.contactos']);
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);
    Route::resource('perfil', 'Backend\PerfilController', ['names' => 'admin.perfil']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::resource('formulario', 'Backend\FormularioController', ['names' => 'admin.formulario']);
    Route::post('/auth/update', 'Backend\UsersController@updatePassword')->name('admin.users.password');
    Route::post('/rutinaup/{id}', 'Backend\RutinasController@updateRutina')->name('admin.rutinas.rutinaup');

    // Extras
    Route::post('/rutuser', 'Backend\RutinasController@user')->name('admin.rutinas.user');

    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');

    // Desvincular google
    Route::post('/google/unlink', 'Backend\Auth\LoginController@unlink')->name('admin.google.unlink');

    // Forget Password Routes
    // Route::get('/password/reset', 'Backend\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    // Route::post('/password/reset/submit', 'Backend\Auth\ForgotPasswordController@reset')->name('admin.password.update');
});

// Forget Password
Route::get('/password/reset', 'Backend\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('/password/reset/submit', 'Backend\Auth\ForgotPasswordController@reset')->name('admin.password.update');

// Socialite Routes
Route::get('/auth/redirect', 'Backend\Auth\LoginController@redirect')->name('login.redirect');
Route::get('/auth/callback', 'Backend\Auth\LoginController@callback')->name('login.callback');

Route::get('/android', function () {
    $path = public_path('app/modo-gym_android.apk');
    if (file_exists($path)) {
        return response()->download($path, 'modo-gym_android.apk');
    }

    return redirect()->back()->with('error', 'Error en la descarga');
})->name('android');

Route::get('/ios', function () {
    $path = public_path('app/modo-gym_ios.apk');
    if (file_exists($path)) {
        return response()->download($path, 'modo-gym_ios.apk');
    }

    return redirect()->back()->with('error', 'Error en la descarga');
})->name('ios');
