<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\TicketsRepositoryInterface;
use App\Models\Admin\Companies;
use App\Models\Admin\Sla;
use App\Models\Admin\SupportGroup;
use App\Models\Admin\Systems;
use App\Models\Admin\Ticket;
use App\Models\Admin\TicketCategory;
use App\Models\Admin\TicketPriority;
use App\Models\Admin\TicketStatus;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class TicketsRepository implements TicketsRepositoryInterface
{
    protected $tickets;
    protected $priority;
    protected $status;
    protected $companies;
    protected $system;
    protected $sla;
    protected $category;
    protected $groups;
    protected $users;


    public function __construct(
        Ticket $tickets,
        TicketPriority $priority,
        TicketStatus $status,
        Companies $companies,
        Systems $system,
        Sla $sla,
        TicketCategory $category,
        SupportGroup $groups,
        User $users
    ) {
        $this->tickets = $tickets;
        $this->priority = $priority;
        $this->status = $status;
        $this->companies = $companies;
        $this->system = $system;
        $this->sla = $sla;
        $this->category = $category;
        $this->groups = $groups;
        $this->users = $users;
    }

    public function all($filters)
    {
        try {
            return $this->tickets->with(['status', 'priority', 'requester', 'company', 'system', 'agent'])
                ->when($filters, function ($query) use ($filters) {
                    if (isset($filters['company_id'])) {
                        $query->where('company_id', $filters['company_id']);
                    }
                    if (isset($filters['system_id'])) {
                        $query->where('system_id', $filters['system_id']);
                    }
                    if (isset($filters['priority_id'])) {
                        $query->where('priority_id', $filters['priority_id']);
                    }
                    if (isset($filters['status_id'])) {
                        $query->where('status_id', $filters['status_id']);
                    }
                    if (isset($filters['due_date'])) {
                        $query->whereDate('due_date', $filters['due_date']);
                    }
                    if (isset($filters['protocol'])) {
                        $query->where('protocol', $filters['protocol']);
                    }
                    return $query;
                })
                ->orderBy('priority_id', 'desc')
                ->paginate(10);
        } catch (Exception $err) {
            Log::error('Erro ao listar registros Tickets', [$err->getMessage()]);
            return false;
        }
    }

    public function find($id)
    {
        try {
            return $this->tickets->with(['company', 'system', 'status', 'priority', 'agent'])->find($id);
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

    public function listAgents()
    {
        try {
            return $this->users->select(['id', 'name'])->agents()->get();
        } catch (Exception $err) {
            Log::error('Erro ao exibir lista de agentes', [$err->getMessage()]);
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

    public function listSla()
    {
        try {
            return $this->sla->select(['id', 'name'])->get();
        } catch (Exception $err) {
            Log::error('Erro ao exibir lista de status', [$err->getMessage()]);
            return false;
        }
    }

    public function listCategory()
    {
        try {
            return $this->category->select(['id', 'name'])->get();
        } catch (Exception $err) {
            Log::error('Erro ao exibir lista de status', [$err->getMessage()]);
            return false;
        }
    }
    public function listGroups()
    {
        try {
            return $this->groups->select(['id', 'name'])->get();
        } catch (Exception $err) {
            Log::error('Erro ao exibir lista de status', [$err->getMessage()]);
            return false;
        }
    }
}