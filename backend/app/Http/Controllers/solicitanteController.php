<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Solicitante as ResourcesSolicitante;
use App\Models\Solicitante;

class solicitanteController extends Controller
{
    public function index()
    {
        $solicitante = Solicitante::all();
        return ResourcesSolicitante::collection($solicitante);
    }

    public function cadastrar(Request $request)
    {
        $solicitante = new Solicitante();
        $solicitante->nome = $request->input('nome');
        $solicitante->email = $request->input('email');
        $solicitante->password = $request->input('password');
        $solicitante->save();

        if ($solicitante->save()) {
            return new ResourcesSolicitante($solicitante);
        }
    }

    public function show($id)
    {
        $Solicitante = Solicitante::findOrFail($id);
        return new ResourcesSolicitante($Solicitante);
    }

    public function editar(Request $request)
    {
        $solicitante = new Solicitante();
        $solicitante->nome = $request->input('nome');
        $solicitante->email = $request->input('email');
        $solicitante->password = $request->input('password');
        $solicitante->save();

        if ($solicitante->save()) {
            return new ResourcesSolicitante($solicitante);
        }
    }

    public function deletar($id)
    {
        $solicitante = Solicitante::findOrFail($id);
        if ($solicitante->delete()) {
            return new ResourcesSolicitante($solicitante);
        }
    }
}
