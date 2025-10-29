<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\CompaniesRepositoryInterface;
use App\Models\Admin\Companies;
use App\Models\Admin\SystemCategories;
use App\Models\Admin\Systems;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;

class CompaniesRepository implements CompaniesRepositoryInterface
{
    protected $companies;
    protected $systemCategories;
    protected $systems;

    public function __construct(Companies $companies, SystemCategories $systemCategories, Systems $systems)
    {
        $this->companies = $companies;
        $this->systemCategories = $systemCategories;
        $this->systems = $systems;
    }

    public function all($term)
    {
        try {
            return $this->companies
                ->with('systems.category')
                ->when($term, function ($query) use ($term) {
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
            return $this->companies->with('systems.category')->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar registro Companies', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $data, array $systemsData)
    {
        DB::beginTransaction();
        try {
            $company = $this->companies->create($data);
            foreach ($systemsData as $system) {
                $this->systems->create([
                    'name' => $system['name'],
                    'description' => $system['description'],
                    'category_id' => $system['category_id'],
                    'company_id' => $company->id,
                ]);
            }
            DB::commit();
            return true;
        } catch (Exception $err) {
            DB::rollBack();
            Log::error('Erro ao cadastrar Companies', [$err->getMessage()]);
            return false;
        }
    }

    public function update($id, array $data, array $systemsData)
    {
        DB::beginTransaction();
        try {
            $company = $this->companies->findOrFail($id);
            $company->update($data);

            $existingSystems = $this->systems->where('company_id', $company->id)->get();

            $incomingIds = collect($systemsData)
                ->pluck('id')
                ->filter()
                ->toArray();

            $systemsToDelete = $existingSystems->whereNotIn('id', $incomingIds);
            foreach ($systemsToDelete as $system) {
                $system->delete();
            }

            foreach ($systemsData as $systemData) {
                if (isset($systemData['id'])) {
                    $system = $this->systems->find($systemData['id']);
                    if ($system) {
                        $system->update([
                            'name' => $systemData['name'],
                            'description' => $systemData['description'] ?? null,
                            'category_id' => $systemData['category_id'],
                        ]);
                    }
                } else {
                    $this->systems->create([
                        'company_id' => $company->id,
                        'name' => $systemData['name'],
                        'description' => $systemData['description'] ?? null,
                        'category_id' => $systemData['category_id'],
                        'active' => true,
                    ]);
                }
            }

            DB::commit();
            return $company;

        } catch (Exception $err) {
            DB::rollBack();
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

    public function disable($id)
    {
        try {
            $item = $this->companies->find($id);
            $item->update(['active' => !$item->active]);
            return $item;
        } catch (Exception $err) {
            Log::error('Erro ao excluir Companies', [$err->getMessage()]);
            return false;
        }
    }

    public function listSystemCategories()
    {
        try {
            return $this->systemCategories->get();
        } catch (Exception $err) {
            Log::error('Erro ao listar categorias', [$err->getMessage()]);
            return false;
        }
    }
}