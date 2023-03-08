<?php

namespace App\Http\Controllers;

use App\Http\Resources\NivelUsuario as ResourcesNivelUsuario;
use App\Models\NivelUsuario;
use Illuminate\Http\Request;

class NivelUsuarioController extends Controller
{
    public function index()
    {
        $nivelUsuario = NivelUsuario::all();
        return ResourcesNivelUsuario::collection($nivelUsuario);
    }

    public function show($id)
    {
        $nivelUsuario = NivelUsuario::findOrFail($id);
        return new ResourcesNivelUsuario($nivelUsuario);
    }
}
