<?php

namespace App\Repositories\Ticket;

use App\Interfaces\Ticket\CompanyRepositoryInterface;
use App\Models\Ticket\Company;
use Carbon\Carbon;
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
        try {
            return $this->company->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar empresa', ['erro' => $err->getMessage()]);
            return $err->getMessage();
        }
    }

    public function create(array $data)
    {
        try {
            return $this->company->create($data);
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar empresa', ['erro' => $err->getMessage()]);
            return $err->getMessage();
        }
    }

    public function update($id, array $data)
    {

        try {
            $company = $this->company->find($id);

            $company->address = $data['address'];
            $company->cnpj = $data['cnpj'];
            $company->email = $data['email'];
            $company->name = $data['name'];
            $company->phone = $data['phone'];
            $company->responsible_manager = $data['responsible_manager'];
            $company->updated_at = Carbon::now();
            $company->save();

        } catch (Exception $err) {
            Log::error('Erro ao editar empresa', ['erro' => $err->getMessage()]);
            $err->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $this->company->find($id)->delete();
        } catch (Exception $err) {
            Log::error('Erro ao deletar empresa', ['erro' => $err->getMessage()]);
            return $err->getMessage();
        }
    }
}