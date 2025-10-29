<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\SystemCategoryRepositoryInterface;
use App\Models\Admin\SystemCategory;
use Exception;
use Illuminate\Support\Facades\Log;

class SystemCategoryRepository implements SystemCategoryRepositoryInterface
{
    protected $systemCategory;

    public function __construct(SystemCategory $systemCategory)
    {
        $this->systemCategory = $systemCategory;
    }

    public function all($term)
    {
        try {
            return $this->systemCategory
                ->when($term, function ($query) use ($term) {
                    // ajuste seus campos de busca aqui
                    return $query->where('name', 'like', '%' . $term . '%');
                })
                ->paginate(10);
        } catch (Exception $err) {
            Log::error('Erro ao listar registros SystemCategory', [$err->getMessage()]);
            return false;
        }
    }

    public function find($id)
    {
        try {
            return $this->systemCategory->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar registro SystemCategory', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $data)
    {
        try {
            return $this->systemCategory->create($data);
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar SystemCategory', [$err->getMessage()]);
            return false;
        }
    }

    public function update($id, array $data)
    {
        try {
            $item = $this->systemCategory->find($id);
            $item->update($data);
            return $item;
        } catch (Exception $err) {
            Log::error('Erro ao atualizar SystemCategory', [$err->getMessage()]);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $item = $this->systemCategory->find($id);
            $item->delete();
            return true;
        } catch (Exception $err) {
            Log::error('Erro ao excluir SystemCategory', [$err->getMessage()]);
            return false;
        }
    }

    public function disable($id)
    {
        try {
            $item = $this->systemCategory->find($id);
            $item->update(['active' => !$item->active]);
            return $item;
        } catch (Exception $err) {
            Log::error('Erro ao excluir Companies', [$err->getMessage()]);
            return false;
        }
    }
}