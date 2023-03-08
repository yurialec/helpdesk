<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChamadoStatus as ResourcesChamadoStatus;
use App\Models\ChamadoStatus;
use Illuminate\Http\Request;

class ChamadoStatusController extends Controller
{
    public function index()
    {
        $chamadoStatus = ChamadoStatus::all();
        return ResourcesChamadoStatus::collection($chamadoStatus);
    }

    public function show($id)
    {
        $chamadoStatusId = ChamadoStatus::findOrFail($id);
        return new ResourcesChamadoStatus($chamadoStatusId);
    }
}
