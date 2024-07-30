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
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);

    // Extras
    Route::post('/rutuser', 'Backend\RutinasController@user')->name('admin.rutinas.user');

    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');

    // Forget Password Routes
    Route::get('/password/reset', 'Backend\Auth\ForgetPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset/submit', 'Backend\Auth\ForgetPasswordController@reset')->name('admin.password.update');
});
