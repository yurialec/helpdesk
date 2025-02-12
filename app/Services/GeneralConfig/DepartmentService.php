<?php

namespace App\Services\GeneralConfig;

use App\Repositories\GeneralConfig\DepartmentRepository;

class DepartmentService
{
    protected $DepartmentRepository;

    public function __construct(DepartmentRepository $DepartmentRepository)
    {
        $this->DepartmentRepository = $DepartmentRepository;
    }

    public function all()
    {
        return $this->DepartmentRepository->all();
    }
}