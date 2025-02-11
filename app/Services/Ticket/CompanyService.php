<?php

namespace App\Services\Ticket;

use App\Repositories\Ticket\CompanyRepository;

class CompanyService
{
    protected $CompanyRepository;

    public function __construct(CompanyRepository $CompanyRepository)
    {
        $this->CompanyRepository = $CompanyRepository;
    }

    public function all($term = null)
    {
        return $this->CompanyRepository->all($term = null);
    }

    public function create(array $data)
    {
        return $this->CompanyRepository->create($data);
    }
}