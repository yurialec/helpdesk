<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\TicketsService;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    protected $ticketsService;

    public function __construct(TicketsService $ticketsService)
    {
        $this->ticketsService = $ticketsService;
    }

    public function index()
    {
        return view('admin.tickets.index');
    }

    public function list(Request $request)
    {
        $items = $this->ticketsService->getAll($request->input('search'));

        if ($items) {
            return response()->json(['status' => true, 'items' => $items], 200);
        }
        return response()->json(['message' => 'Nenhum registro encontrado.', 'status' => 500]);
    }

    public function create()
    {
        return view('admin.tickets.create');
    }

    public function store(Request $request)
    {
        $item = $this->ticketsService->create($request->all());

        if ($item) {
            return response()->json(['status' => true, 'item' => $item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Erro ao cadastrar registro'], 500);
    }

    public function edit($id)
    {
        return view('admin.tickets.edit', compact('id'));
    }

    public function find($id)
    {
        $item = $this->ticketsService->find($id);

        if ($item) {
            return response()->json(['status' => true, 'item' => $item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Registro não encontrado'], 500);
    }

    public function update(Request $request, string $id)
    {
        $item = $this->ticketsService->update($id, $request->all());

        if ($item) {
            return response()->json(['status' => true, 'item' => $item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Erro ao atualizar registro'], 500);
    }

    public function delete(string $id)
    {
        $deleted = $this->ticketsService->delete($id);

        if ($deleted) {
            return response()->json(['status' => true, 'message' => 'Registro excluído com sucesso'], 200);
        }
        return response()->json(['status' => false, 'message' => 'Erro ao excluir registro'], 500);
    }

    public function listPriorities()
    {
        $item = $this->ticketsService->listPriorities();

        if ($item) {
            return response()->json(['status' => true, 'item' => $item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Registro não encontrado'], 500);
    }
    
    public function listStatus()
    {
        $item = $this->ticketsService->listStatus();

        if ($item) {
            return response()->json(['status' => true, 'item' => $item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Registro não encontrado'], 500);
    }
    public function listCompanies()
    {
        $item = $this->ticketsService->listCompanies();

        if ($item) {
            return response()->json(['status' => true, 'item' => $item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Registro não encontrado'], 500);
    }
    public function listSystems($id)
    {
        $item = $this->ticketsService->listSystems($id);

        if ($item) {
            return response()->json(['status' => true, 'item' => $item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Registro não encontrado'], 500);
    }
}