<?php

namespace App\Interfaces\Admin;

interface CompaniesRepositoryInterface
{
    public function all($term);
    public function find($id);
    public function create(array $data, array $systemsData);
    public function update($id, array $data, array $systemsData);
    public function delete($id);
    public function disable($id);
    public function listSystemCategories();
}