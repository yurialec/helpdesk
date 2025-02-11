<?php

namespace App\Http\Controllers\GeneralConfig;

use App\Http\Controllers\Controller;
use App\Services\GeneralConfig\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $CompanyService;

    public function __construct(CompanyService $CompanyService)
    {
        $this->CompanyService = $CompanyService;
    }

    public function index()
    {
        return view('generalconfig.companies.index');
    }

    public function list()
    {
        $companies = $this->CompanyService->all();

        if ($companies) {
            return response()->json([
                'status' => true,
                'companies' => $companies,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao localizar empresas'
            ], 204);
        }
    }

    public function create()
    {
        return view('generalconfig.companies.create');
    }

    public function store(Request $request)
    {
        $company = $this->CompanyService->create($request->all());

        if ($company) {
            return response()->json([
                'status' => true,
                'company' => $company,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar empresa'
            ], 204);
        }
    }

    public function edit($id)
    {
        return view('generalconfig.companies.edit', compact('id'));
    }

    public function find($id)
    {
        $company = $this->CompanyService->find($id);

        if ($company) {
            return response()->json([
                'company' => $company,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar empresa'
            ], 204);
        }
    }

    public function update($id, Request $request)
    {
        $data = $request->data;
        $company = $this->CompanyService->update($id, $data);

        if ($company) {
            return response()->json([
                'company' => $company,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar empresa'
            ], 204);
        }
    }

    public function delete($id)
    {
        return $this->CompanyService->delete($id);
    }
}