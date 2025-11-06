<?php

namespace App\Services\Admin;

use App\Models\Admin\TicketStatus;
use App\Repositories\Admin\TicketsRepository;
use App\Utils\GenetateProtocol;
use Auth;

class TicketsService
{
    protected $ticketsRepository;

    public function __construct(TicketsRepository $ticketsRepository)
    {
        $this->ticketsRepository = $ticketsRepository;
    }

    public function getAll($term)
    {
        return $this->ticketsRepository->all($term);
    }

    public function find($id)
    {
        return $this->ticketsRepository->find($id);
    }

    public function create($data)
    {
        $ticketData = [
            'protocol' => GenetateProtocol::generate(),
            'company_id' => $data['company_id'],
            'system_id' => $data['system_id'],
            'requester_id' => Auth::id(),
            'priority_id' => $data['priority_id'],
            'subject' => $data['subject'],
            'description' => $data['description'],
            'due_date' => $data['due_date'] ?? now()->addDays(1),
            'status_id' => TicketStatus::STATUS_OPEN,
            'type' => $data['type'],
            'impact' => $data['impact'],
            'urgency' => $data['urgency'],
            'sla_id' => $data['sla_id'],
            'category_id' => $data['category_id'],
            'group_id' => $data['group_id'],
        ];

        return $this->ticketsRepository->create($ticketData);
    }

    public function update($id, $data)
    {
        return $this->ticketsRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->ticketsRepository->delete($id);
    }

    public function listPriorities()
    {
        return $this->ticketsRepository->listPriorities();
    }
    public function listStatus()
    {
        return $this->ticketsRepository->listStatus();
    }
    public function listCompanies()
    {
        return $this->ticketsRepository->listCompanies();
    }
    public function listSystems($id)
    {
        return $this->ticketsRepository->listSystems($id);
    }
    public function listSla()
    {
        return $this->ticketsRepository->listSla();
    }
    public function listCategory()
    {
        return $this->ticketsRepository->listCategory();
    }
    public function listGroups()
    {
        return $this->ticketsRepository->listGroups();
    }
}