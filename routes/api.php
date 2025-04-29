<?php

use App\Http\Controllers\API\BlogsController;
use App\Http\Controllers\API\EjerciciosController;
use App\Http\Controllers\API\EquiposController;
use App\Http\Controllers\API\FormularioController;
use App\Http\Controllers\API\LikesController;
use App\Http\Controllers\API\LoginAppController;
use App\Http\Controllers\API\MedidasController;
use App\Http\Controllers\API\MusculosController;
use App\Http\Controllers\API\NutricionController;
use App\Http\Controllers\API\PlanesController;
use App\Http\Controllers\API\RutinaController;
use App\Http\Controllers\API\RutinasController;
use App\Http\Controllers\API\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('apiCredential')->group(function () {
    Route::post('/registra-asistencia', [UsuarioController::class, 'registrar_asistencia']);
    Route::get('/usuario/{ci}', [UsuarioController::class, 'usuario']);
    Route::post('/registra-huella', [UsuarioController::class, 'huella']);
});

Route::get('/', [LoginAppController::class, 'getStatus']);
Route::post('/login-app', [LoginAppController::class, 'loginApp']);

// Reset password
Route::post('/forgot-password', [LoginAppController::class, 'forgotPassword']);
Route::post('/profile-app', [LoginAppController::class, 'registerUser']);
Route::get('/google-app/{id}', [LoginAppController::class, 'searchGoogleId']);
Route::get('/email-app/{email}', [LoginAppController::class, 'searchEmail']);
//

Route::get('/profile-app/{id}', [LoginAppController::class, 'getProfile']);

Route::get('/rutinas-app-user/{id}', [RutinasController::class, 'rutinasUser']);
Route::get('/rutinas-app-user-dia/{id}/{dia?}', [RutinasController::class, 'rutinasUserDia']);

// Route::get('/ejercicios-app', [EjerciciosController::class, 'ejerciciosApp']);
// Route::get('/blogs-app-user/{id}', [BlogsController::class, 'blogsAppUser']);

Route::middleware(['authApp', 'auth:sanctum'])->group(function () {
    Route::get('/auth-app', [LoginAppController::class, 'authApp']);
    Route::get('/profile-app', [LoginAppController::class, 'getProfile']);
    Route::put('/profile-app', [LoginAppController::class, 'updateProfile']);
    Route::put('/password-app', [LoginAppController::class, 'updatePassword']);

    // Route::get('/rutinas-app-dia/{dia?}', [RutinasController::class, 'rutinasUserDia']);
    // Route::resource('/rutinas-app', RutinasController::class);
    Route::resource('/blogs-app', BlogsController::class);
    Route::resource('/ejercicios-app', EjerciciosController::class);
    Route::resource('/musculos-app', MusculosController::class);
    Route::resource('/equipos-app', EquiposController::class);
    Route::resource('/rutina-app', RutinaController::class);
    Route::delete('/rutina-app-serie/{id}', [RutinaController::class, 'destroyRutina']);
    Route::delete('/rutina-app-ejercicio/{id}', [RutinaController::class, 'destroyEjercicio']);
    Route::resource('/nutricion-app', NutricionController::class);
    Route::resource('/medidas-app', MedidasController::class);
    Route::resource('/likes-app', LikesController::class);
    Route::resource('/planes-app', PlanesController::class);

    Route::resource('/rutinas-app', RutinasController::class);
    Route::post('/rutinas-renovar-app', [RutinasController::class, 'renovarEjercicios']);
    Route::resource('/formulario-app', FormularioController::class);

    Route::post('/logout-app', [LoginAppController::class, 'logoutApp']);
});
