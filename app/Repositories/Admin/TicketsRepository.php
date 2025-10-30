<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\TicketsRepositoryInterface;
use App\Models\Admin\Companies;
use App\Models\Admin\Systems;
use App\Models\Admin\TicketPriority;
use App\Models\Admin\Tickets;
use App\Models\Admin\TicketStatus;
use Exception;
use Illuminate\Support\Facades\Log;

class TicketsRepository implements TicketsRepositoryInterface
{
    protected $tickets;
    protected $priority;
    protected $status;
    protected $companies;
    protected $system;


    public function __construct(Tickets $tickets, TicketPriority $priority, TicketStatus $status, Companies $companies, Systems $system)
    {
        $this->tickets = $tickets;
        $this->priority = $priority;
        $this->status = $status;
        $this->companies = $companies;
        $this->system = $system;
    }

    public function all($term)
    {
        try {
            return $this->tickets->with(['company', 'system', 'status', 'priority'])
                ->when($term, function ($query) use ($term) {
                    return $query->where('id', 'like', '%' . $term . '%');
                })
                ->paginate(10);
        } catch (Exception $err) {
            Log::error('Erro ao listar registros Tickets', [$err->getMessage()]);
            return false;
        }
    }

    public function find($id)
    {
        try {
            return $this->tickets->with(['company', 'system', 'status', 'priority'])->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar registro Tickets', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $data)
    {
        try {
            return $this->tickets->create($data);
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar Tickets', [$err->getMessage()]);
            return false;
        }
    }

    public function update($id, array $data)
    {
        try {
            $item = $this->tickets->find($id);
            $item->update($data);
            return $item;
        } catch (Exception $err) {
            Log::error('Erro ao atualizar Tickets', [$err->getMessage()]);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $item = $this->tickets->find($id);
            $item->delete();
            return true;
        } catch (Exception $err) {
            Log::error('Erro ao excluir Tickets', [$err->getMessage()]);
            return false;
        }
    }

    public function listPriorities()
    {
        try {
            return $this->priority->get();
        } catch (Exception $err) {
            Log::error('Erro ao exibir lista de prioridades', [$err->getMessage()]);
            return false;
        }
    }

    public function listStatus()
    {
        try {
            return $this->status->get();
        } catch (Exception $err) {
            Log::error('Erro ao exibir lista de status', [$err->getMessage()]);
            return false;
        }
    }

    public function listCompanies()
    {
        try {
            return $this->companies->select(['id', 'name'])->where('active', true)->get();
        } catch (Exception $err) {
            Log::error('Erro ao exibir lista de status', [$err->getMessage()]);
            return false;
        }
    }

    public function listSystems($id)
    {
        try {
            return $this->system->select(['id', 'name'])->where('company_id', $id)->get();
        } catch (Exception $err) {
            Log::error('Erro ao exibir lista de status', [$err->getMessage()]);
            return false;
        }
    }
}