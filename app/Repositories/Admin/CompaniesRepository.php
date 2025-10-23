<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\CompaniesRepositoryInterface;
use App\Models\Admin\Companies;
use Exception;
use Illuminate\Support\Facades\Log;

class CompaniesRepository implements CompaniesRepositoryInterface
{
    protected $companies;

    public function __construct(Companies $companies)
    {
        $this->companies = $companies;
    }

    public function all($term)
    {
        try {
            return $this->companies
                ->when($term, function ($query) use ($term) {
                    // ajuste seus campos de busca aqui
                    return $query->where('name', 'like', '%' . $term . '%');
                })
                ->paginate(10);
        } catch (Exception $err) {
            Log::error('Erro ao listar registros Companies', [$err->getMessage()]);
            return false;
        }
    }

    public function find($id)
    {
        try {
            return $this->companies->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar registro Companies', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $data)
    {
        try {
            return $this->companies->create($data);
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar Companies', [$err->getMessage()]);
            return false;
        }
    }

    public function update($id, array $data)
    {
        try {
            $item = $this->companies->find($id);
            $item->update($data);
            return $item;
        } catch (Exception $err) {
            Log::error('Erro ao atualizar Companies', [$err->getMessage()]);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $item = $this->companies->find($id);
            $item->delete();
            return true;
        } catch (Exception $err) {
            Log::error('Erro ao excluir Companies', [$err->getMessage()]);
            return false;
        }
    }
}