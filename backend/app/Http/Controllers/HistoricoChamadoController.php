<?php

namespace App\Http\Controllers;

use App\Http\Resources\HistoricoChamado as ResourcesHistoricoChamado;
use App\Models\HistoricoChamado;
use Illuminate\Http\Request;

class HistoricoChamadoController extends Controller
{
    public function index()
    {
        $historicoChamados = HistoricoChamado::all();
        return ResourcesHistoricoChamado::collection($historicoChamados);
    }

    public function show($id)
    {
        $historicoChamado = HistoricoChamado::findOrFail($id);
        return new ResourcesHistoricoChamado($historicoChamado);
    }

    public function cadastrar(Request $request)
    {
        $historicoChamado = new HistoricoChamado;
        $historicoChamado->chamado_id = $request->input('chamado_id');
        $historicoChamado->chamado_statu_id = $request->input('chamado_statu_id');
        $historicoChamado->usuario_id = $request->input('usuario_id');
        $historicoChamado->save();

        if ($historicoChamado->save()) {
            return new ResourcesHistoricoChamado($historicoChamado);
        }
    }

    public function editar(Request $request)
    {
        $historicoChamado = new HistoricoChamado;
        $historicoChamado->chamado_id = $request->input('chamado_id');
        $historicoChamado->chamado_statu_id = $request->input('chamado_statu_id');
        $historicoChamado->usuario_id = $request->input('usuario_id');
        $historicoChamado->save();

        if ($historicoChamado->save()) {
            return new ResourcesHistoricoChamado($historicoChamado);
        }
    }

    public function deletar($id)
    {
        $historicoChamado = HistoricoChamado::findOrFail($id);
        if ($historicoChamado->delete()) {
            return new ResourcesHistoricoChamado($historicoChamado);
        }
    }
}
