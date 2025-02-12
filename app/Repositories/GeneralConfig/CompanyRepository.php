<?php

namespace App\Repositories\GeneralConfig;

use App\Interfaces\GeneralConfig\CompanyRepositoryInterface;
use App\Models\GeneralConfig\Company;
use App\Models\GeneralConfig\CompanyDepartment;
use App\Models\GeneralConfig\Department;
use Carbon\Carbon;
use Exception;
use Log;

class CompanyRepository implements CompanyRepositoryInterface
{
    protected $company;
    protected $department;
    protected $companyDepartment;


    public function __construct(Company $company, Department $department, CompanyDepartment $companyDepartment)
    {
        $this->company = $company;
        $this->department = $department;
        $this->companyDepartment = $companyDepartment;
    }

    public function all($term = null)
    {
        return $this->company
            ->when($term, function ($query) use ($term) {
                return $query->where('name', 'like', '%' . $term . '%');
            })
            ->with('departments')
            ->paginate(10);
    }

    public function find($id)
    {
        try {
            return $this->company->with('departments')->find($id);
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

    public function update($id, $data, $departments)
    {
        try {
            $company = $this->company->find($id);

            if (!$company) {
                return false;
            }

            $company->address = $data['address'];
            $company->cnpj = $data['cnpj'];
            $company->email = $data['email'];
            $company->name = $data['name'];
            $company->phone = $data['phone'];
            $company->responsible_manager = $data['responsible_manager'];
            $company->save();

            if (!empty($departments)) {
                $this->companyDepartment->where('company_id', $id)->delete();

                foreach ($departments as $key => $value) {
                    $this->companyDepartment->create([
                        'company_id' => $id,
                        'department_id' => $value['id'],
                    ]);
                }
            }

            return true;

        } catch (Exception $err) {
            Log::error('Erro ao editar empresa', ['erro' => $err->getMessage()]);
            return false;
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

    public function listDepartments()
    {
        try {
            return $this->department->get();
        } catch (Exception $err) {
            Log::error('Erro ao listar departamentos', ['erro' => $err->getMessage()]);
            return $err->getMessage();
        }
    }
}