<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SystemCategory\StoreSystemCategoryRequest;
use App\Http\Requests\Admin\SystemCategory\UpdateSystemCategoryRequest;
use App\Services\Admin\SystemCategoryService;
use Illuminate\Http\Request;

class SystemCategoryController extends Controller
{
    protected $systemCategoryService;

    public function __construct(SystemCategoryService $systemCategoryService)
    {
        $this->systemCategoryService = $systemCategoryService;
    }

    public function index()
    {
        return view('admin.system-category.index');
    }

    public function list(Request $request)
    {
        $items = $this->systemCategoryService->getAll($request->input('search'));

        if ($items) {
            return response()->json([
                'status' => true,
                'items' => $items
            ], 200);
        }
        return response()->json([
            'message' => 'Nenhum registro encontrado.',
            'status' => 500
        ]);
    }

    public function create()
    {
        return view('admin.system-category.create');
    }

    public function store(StoreSystemCategoryRequest $request)
    {
        $item = $this->systemCategoryService->create($request->all());

        if ($item) {
            return response()->json([
                'status' => true,
                'item' => $item
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Erro ao cadastrar registro'
        ], 500);
    }

    public function edit($id)
    {
        return view('admin.system-category.edit', compact('id'));
    }

    public function find($id)
    {
        $item = $this->systemCategoryService->find($id);

        if ($item) {
            return response()->json([
                'status' => true,
                'item' => $item
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Registro não encontrado'
        ], 500);
    }

    public function update(UpdateSystemCategoryRequest $request, string $id)
    {
        $item = $this->systemCategoryService->update($id, $request->all());

        if ($item) {
            return response()->json([
                'status' => true,
                'item' => $item
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Erro ao atualizar registro'
        ], 500);
    }

    public function delete(string $id)
    {
        $deleted = $this->systemCategoryService->delete($id);

        if ($deleted) {
            return response()->json(['status' => true, 'message' => 'Registro excluído com sucesso'], 200);
        }
        return response()->json(['status' => false, 'message' => 'Erro ao excluir registro'], 500);
    }

    public function disable($id)
    {
        $item = $this->systemCategoryService->disable($id);

        if ($item) {
            return response()->json([
                'status' => true,
                'item' => $item
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Erro ao excluir registro'
        ], 500);
    }
}