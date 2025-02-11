<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Services\Ticket\CompanyService;
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
        return view('ticket.companies.index');
    }

    public function list(Request $request)
    {
        $companies = $this->CompanyService->all($term = null);

        return response()->json([
            'companies' => $companies,
        ]);
    }


    public function create()
    {
        return view('ticket.companies.create');
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
}