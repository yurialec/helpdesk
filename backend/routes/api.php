<?php

use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\ChamadoStatusController;
use App\Http\Controllers\NivelUsuarioController;
use App\Http\Controllers\solicitanteController;
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

Route::get('chamado-status', [ChamadoStatusController::class, 'index']);
Route::get('chamado-status/{id}', [ChamadoStatusController::class, 'show']);

Route::get('/solicitantes', [solicitanteController::class, 'index']);
Route::get('solicitante/{id}', [solicitanteController::class, 'show']);
Route::post('cadastrar-solicitante', [solicitanteController::class, 'cadastrar']);
Route::put('editar-solicitante/{id}', [solicitanteController::class, 'editar']);
Route::delete('deletar-solicitantes/{id}', [solicitanteController::class, 'deletar']);

Route::get('/chamados', [ChamadoController::class, 'index']);
Route::get('chamado/{id}', [ChamadoController::class, 'show']);
Route::post('cadastrar-chamado', [ChamadoController::class, 'cadastrar']);
Route::put('editar-chamado/{id}', [ChamadoController::class, 'editar']);
Route::delete('deletar-chamado/{id}', [ChamadoController::class, 'deletar']);