<?php

namespace App\Services\GeneralConfig;

use App\Repositories\GeneralConfig\CompanyRepository;

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

    public function find($id)
    {
        return $this->CompanyRepository->find($id);
    }

    public function update($id, $data)
    {
        return $this->CompanyRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->CompanyRepository->delete($id);
    }
}