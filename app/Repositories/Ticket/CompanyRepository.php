<?php

namespace App\Repositories\Ticket;

use App\Interfaces\Ticket\CompanyRepositoryInterface;
use App\Models\Ticket\Company;
use Exception;
use Log;

class CompanyRepository implements CompanyRepositoryInterface
{
    protected $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function all($term = null)
    {
        return $this->company
            ->when($term, function ($query) use ($term) {
                return $query->where('name', 'like', '%' . $term . '%');
            })
            ->paginate(10);
    }

    public function find($id)
    {
        return Company::find($id);
    }

    public function create(array $data)
    {
        try {
            return Company::create($data);
        } catch (Exception $err) {

            Log::error('Erro ao cadastrar empresa', ['erro' => $err->getMessage()]);
            return $err->getMessage();
        }
    }

    public function update($id, array $data)
    {
        $model = Company::find($id);
        if ($model) {
            $model->update($data);
            return $model;
        }
        return null;
    }

    public function delete($id)
    {
        return Company::destroy($id);
    }
}