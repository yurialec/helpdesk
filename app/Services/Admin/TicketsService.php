<?php

namespace App\Services\Admin;

use App\Enums\TicketLogActions;
use App\Models\Admin\Ticket;
use App\Models\Admin\TicketAttachment;
use App\Models\Admin\TicketLog;
use App\Models\Admin\TicketStatus;
use App\Repositories\Admin\TicketsRepository;
use App\Utils\TicketHelper;
use Auth;
use Storage;

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
            'protocol' => TicketHelper::generateProtocol(),
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
            'agent_id' => TicketHelper::nextAgent(),
        ];


        $ticket = $this->ticketsRepository->create($ticketData);

        $this->log(
            ticketId: $ticket->id,
            action: TicketLogActions::CREATED,
            message: "Ticket criado pelo usuário"
        );

        return $ticket;
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
    public function listAgents()
    {
        return $this->ticketsRepository->listAgents();
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


    // ==============================================
    //  METODOS AUXILIARES, VERIFICAR ONDE FICARÃO
    // ==============================================
    private function log($ticketId, $action, $from = null, $to = null, $message = null): void
    {
        TicketLog::create([
            'ticket_id' => $ticketId,
            'user_id' => Auth::id(),
            'action' => $action,
            'from' => $from,
            'to' => $to,
            'message' => $message
        ]);
    }

    public function changeStatus($ticketId, $newStatus)
    {
        $ticket = Ticket::findOrFail($ticketId);

        $oldStatus = $ticket->status_id;

        $ticket->update(['status_id' => $newStatus]);

        $this->log(
            ticketId: $ticketId,
            action: TicketLogActions::STATUS_CHANGED,
            from: $oldStatus,
            to: $newStatus
        );
    }

    public function transferAgent($ticketId, $newAgentId)
    {
        $ticket = Ticket::findOrFail($ticketId);

        $oldAgent = $ticket->agent_id;

        $ticket->update(['agent_id' => $newAgentId]);

        $this->log(
            ticketId: $ticketId,
            action: TicketLogActions::AGENT_CHANGED,
            from: $oldAgent,
            to: $newAgentId
        );
    }

    // Verificar, nao sei se é necessario
    public function addInternalNote($ticketId, $message)
    {
        $this->log(
            ticketId: $ticketId,
            action: TicketLogActions::INTERNAL_NOTE,
            message: $message
        );
    }

    // Verificar, nao sei se é necessario
    public function addPublicReply($ticketId, $message)
    {
        $this->log(
            ticketId: $ticketId,
            action: TicketLogActions::PUBLIC_REPLY,
            message: $message
        );
    }

    public function addAttachment($ticketId, $filePath, $fileName)
    {
        TicketAttachment::create([
            'ticket_id' => $ticketId,
            'user_id' => Auth::id(),
            'file_path' => $filePath,
            'original_name' => $fileName,
            'size' => Storage::size($filePath),
        ]);

        $this->log(
            ticketId: $ticketId,
            action: TicketLogActions::ATTACHMENT,
            message: "Arquivo anexado: {$fileName}"
        );
    }
}