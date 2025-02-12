<?php

namespace App\Http\Controllers\GeneralConfig;

use App\Http\Controllers\Controller;
use App\Services\GeneralConfig\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $DepartmentService;

    public function __construct(DepartmentService $DepartmentService)
    {
        $this->DepartmentService = $DepartmentService;
    }

    public function index()
    {
        return view('generalconfig.department.index');
    }

    public function list()
    {
        $departments = $this->DepartmentService->all();

        if ($departments) {
            return response()->json([
                'status' => true,
                'departments' => $departments,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao localizar empresas'
            ], 204);
        }
    }
}