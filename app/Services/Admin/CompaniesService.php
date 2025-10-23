<?php

namespace App\Services\Admin;

use App\Repositories\Admin\CompaniesRepository;
use App\Utils\Formatter;

class CompaniesService
{
    protected $companiesRepository;

    public function __construct(CompaniesRepository $companiesRepository)
    {
        $this->companiesRepository = $companiesRepository;
    }

    public function getAll($term)
    {
        return $this->companiesRepository->all($term);
    }

    public function find($id)
    {
        return $this->companiesRepository->find($id);
    }

    public function create($data)
    {
        $companieData = [
            "name" => $data['name'],
            "cnpj" => Formatter::onlyNumbers($data['cnpj']),
            "email" => $data['email'],
            "phone" => Formatter::onlyNumbers($data['phone']),
            "address" => $data['address'],
        ];

        return $this->companiesRepository->create($companieData);
    }

    public function update($id, $data)
    {
        // solicitado: repassar $data sem tratamento
        return $this->companiesRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->companiesRepository->delete($id);
    }
}