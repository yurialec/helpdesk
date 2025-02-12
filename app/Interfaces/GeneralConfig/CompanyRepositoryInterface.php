<?php

namespace App\Interfaces\GeneralConfig;

interface CompanyRepositoryInterface
{
    public function all($term = null);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data, $departments);
    public function delete($id);
    public function listDepartments();
}