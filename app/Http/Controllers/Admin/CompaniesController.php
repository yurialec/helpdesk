<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Companie\StoreCompanieRequest;
use App\Services\Admin\CompaniesService;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    protected $companiesService;

    public function __construct(CompaniesService $companiesService)
    {
        $this->companiesService = $companiesService;
    }

    public function index()
    {
        return view('admin.companies.index');
    }

    public function list(Request $request)
    {
        $items = $this->companiesService->getAll($request->input('search'));

        if ($items) {
            return response()->json(['status' => true, 'items' => $items], 200);
        }
        return response()->json(['message' => 'Nenhum registro encontrado.', 'status' => 500]);
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(StoreCompanieRequest $request)
    {
        $item = $this->companiesService->create($request->all());

        if ($item) {
            return response()->json(['status' => true, 'item' => $item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Erro ao cadastrar registro'], 500);
    }

    public function edit($id)
    {
        return view('admin.companies.edit', compact('id'));
    }

    public function find($id)
    {
        $item = $this->companiesService->find($id);

        if ($item) {
            return response()->json(['status' => true, 'item' => $item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Registro não encontrado'], 500);
    }

    public function update(Request $request, string $id)
    {
        $item = $this->companiesService->update($id, $request->all());

        if ($item) {
            return response()->json(['status' => true, 'item' => $item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Erro ao atualizar registro'], 500);
    }

    public function delete(string $id)
    {
        $deleted = $this->companiesService->delete($id);

        if ($deleted) {
            return response()->json(['status' => true, 'message' => 'Registro excluído com sucesso'], 200);
        }
        return response()->json(['status' => false, 'message' => 'Erro ao excluir registro'], 500);
    }
}