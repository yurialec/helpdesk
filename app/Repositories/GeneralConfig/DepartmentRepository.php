<?php

namespace App\Repositories\GeneralConfig;

use App\Interfaces\GeneralConfig\DepartmentRepositoryInterface;
use App\Models\GeneralConfig\Department;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    protected $department;

    public function __construct(Department $department)
    {
        $this->department = $department;
    }

    public function all($term = null)
    {
        return $this->department
            ->when($term, function ($query) use ($term) {
                return $query->where('name', 'like', '%' . $term . '%');
            })
            ->paginate(10);
    }

    public function find($id)
    {
        return $this->department->find($id);
    }

    public function create(array $data)
    {
        return Department::create($data);
    }

    public function update($id, array $data)
    {
        $model = Department::find($id);
        if ($model) {
            $model->update($data);
            return $model;
        }
        return null;
    }

    public function delete($id)
    {
        return Department::destroy($id);
    }
}