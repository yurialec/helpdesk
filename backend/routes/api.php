<?php

use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\ChamadoStatusController;
use App\Http\Controllers\HistoricoChamadoController;
use App\Http\Controllers\NivelUsuarioController;
use App\Http\Controllers\solicitanteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);

Route::prefix('solicitantes')->group(function () {
    Route::get('/', [solicitanteController::class, 'index']);
    Route::get('/{id}', [solicitanteController::class, 'show']);
    Route::post('/cadastrar', [solicitanteController::class, 'cadastrar']);
    Route::put('/editar/{id}', [solicitanteController::class, 'editar']);
    Route::delete('/deletar/{id}', [solicitanteController::class, 'deletar']);
});

Route::prefix('nivel-usuarios')->group(function () {
    Route::get('/', [NivelUsuarioController::class, 'index']);
    Route::get('/{id}', [NivelUsuarioController::class, 'show']);
});

Route::prefix('usuarios')->group(function () {
    Route::get('/', [UsuarioController::class, 'index']);
    Route::get('/{id}', [UsuarioController::class, 'show']);
    Route::post('/cadastrar', [UsuarioController::class, 'cadastrar']);
    Route::put('/editar/{id}', [UsuarioController::class, 'editar']);
    Route::delete('/deletar/{id}', [UsuarioController::class, 'deletar']);
});

Route::prefix('chamado-status')->group(function () {
    Route::get('/', [ChamadoStatusController::class, 'index']);
    Route::get('/{id}', [ChamadoStatusController::class, 'show']);
});

Route::prefix('chamados')->group(function () {
    Route::get('/', [ChamadoController::class, 'index']);
    Route::get('/{id}', [ChamadoController::class, 'show']);
    Route::post('/cadastrar', [ChamadoController::class, 'cadastrar']);
    Route::put('/editar{id}', [ChamadoController::class, 'editar']);
    Route::delete('/deletar/{id}', [ChamadoController::class, 'deletar']);
});

Route::prefix('historico-chamados')->group(function () {
    Route::get('/', [HistoricoChamadoController::class, 'index']);
    Route::get('/{id}', [HistoricoChamadoController::class, 'show']);
    Route::post('/cadastrar', [HistoricoChamadoController::class, 'cadastrar']);
    Route::put('/editar/{id}', [HistoricoChamadoController::class, 'editar']);
    Route::delete('/deletar/{id}', [HistoricoChamadoController::class, 'deletar']);
});
