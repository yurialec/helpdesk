<?php

namespace App\Interfaces\Admin;

interface SystemCategoryRepositoryInterface
{
    public function all($term);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function disable($id);
}