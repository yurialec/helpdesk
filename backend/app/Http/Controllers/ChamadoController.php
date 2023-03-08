<?php

namespace App\Http\Controllers;

use App\Http\Resources\Chamado as ResourcesChamado;
use App\Models\Chamado;
use Illuminate\Http\Request;

class ChamadoController extends Controller
{
    public function index()
    {
        $chamados = Chamado::all();
        return ResourcesChamado::collection($chamados);
    }

    public function cadastrar(Request $request)
    {
        $chamado = new Chamado;
        $chamado->descricao_chamado = $request->input('descricao_chamado');
        $chamado->solicitante_id = $request->input('solicitante_id');
        $chamado->chamado_statu_id = $request->input('chamado_statu_id');
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
        $chamado->save();

        if ($chamado->save()) {
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
