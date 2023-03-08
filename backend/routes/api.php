<?php

use App\Http\Controllers\NivelUsuarioController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('nivel-usuarios', [NivelUsuarioController::class, 'index']);
Route::get('nivel-usuario/{id}', [NivelUsuarioController::class, 'show']);

Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::get('usuario/{id}', [UsuarioController::class, 'show']);
Route::post('cadastrar-usuario', [UsuarioController::class, 'cadastrar']);
Route::put('editar-usuario/{id}', [UsuarioController::class, 'editar']);
Route::delete('deletar-usuario/{id}', [UsuarioController::class, 'deletar']);

