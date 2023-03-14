<?php

namespace App\Http\Controllers;

use App\Http\Resources\Chamado as ResourcesChamado;
use App\Models\Chamado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChamadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $chamados = Chamado::all();
        return ResourcesChamado::collection($chamados);
    }

    public function show($id)
    {
        $chamados = Chamado::findOrFail($id);
        return new ResourcesChamado($chamados);
    }

    public function cadastrar(Request $request)
    {
        $user = Auth::user()->id;

        $chamado = new Chamado;
        $chamado->descricao_chamado = $request->input('descricao_chamado');
        $chamado->solicitante_id = $request->input($user);
        $chamado->chamado_statu_id = $request->input(1);
        $chamado->save();

        if ($chamado->save()) {
            return new ResourcesChamado($chamado);
        }
    }

    public function editar(Request $request)
    {
        $chamado = Chamado::findOrFail($request->id);
        $chamado->descricao_chamado = $request->input('descricao_chamado');
        $chamado->solicitante_id = $request->input('solicitante_id');
        $chamado->chamado_statu_id = $request->input('chamado_statu_id');
        $chamado->update();

        if ($chamado->update()) {
            return new ResourcesChamado($chamado);
        }
    }

    public function deletar($id)
    {
        $chamado = Chamado::findOrFail($id);
        if ($chamado->delete()) {
            return new ResourcesChamado($chamado);
        }
    }
}
