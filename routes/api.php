<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\API\UsuarioController;
use App\Http\Controllers\API\LoginAppController;
use App\Http\Controllers\API\RutinasController;
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
Route::get('/profile-app/{id}', [LoginAppController::class, 'getProfile']);
Route::get('/rutinas-app/{id}', [RutinasController::class, 'rutinasApp']);
