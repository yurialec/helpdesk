<?php

namespace App\Http\Controllers;

use App\Http\Resources\Chamado as ResourcesChamado;
use App\Models\Chamado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChamadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = Auth::user()->id;
        $chamados = Chamado::all()->where('solicitante_id', $user);
        return ResourcesChamado::collection($chamados);
    }

    public function show($id)
    {
        $user = Auth::user()->id;
        $chamados = Chamado::findOrFail($id)->where('solicitante_id', $user);
        return new ResourcesChamado($chamados);
    }

    public function cadastrar(Request $request)
    {
        $user = Auth::user()->id;

        $statement = DB::select("SHOW TABLE STATUS LIKE 'chamados'");
        $nextId = $statement[0]->Auto_increment;

        $chamado = new Chamado;
        $chamado->protocolo = 'P' . '000' . $nextId . date("mY");
        $chamado->descricao_chamado = $request->input('descricao_chamado');
        $chamado->solicitante_id = $user;
        $chamado->chamado_statu_id = 1;
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
