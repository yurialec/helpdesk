<?php

namespace App\Interfaces\Admin;

interface CompaniesRepositoryInterface
{
    public function all($term);
    public function find($id);
    public function create(array $data, array $systemsData);
    public function update($id, array $data);
    public function delete($id);
    public function listSystemCategories();
}