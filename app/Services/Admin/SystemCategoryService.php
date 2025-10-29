<?php

namespace App\Services\Admin;

use App\Repositories\Admin\SystemCategoryRepository;

class SystemCategoryService
{
    protected $systemCategoryRepository;

    public function __construct(SystemCategoryRepository $systemCategoryRepository)
    {
        $this->systemCategoryRepository = $systemCategoryRepository;
    }

    public function getAll($term)
    {
        return $this->systemCategoryRepository->all($term);
    }

    public function find($id)
    {
        return $this->systemCategoryRepository->find($id);
    }

    public function create($data)
    {
        return $this->systemCategoryRepository->create($data);
    }

    public function update($id, $data)
    {
        return $this->systemCategoryRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->systemCategoryRepository->delete($id);
    }

    public function disable($id)
    {
        return $this->systemCategoryRepository->disable($id);
    }
}