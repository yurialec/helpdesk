<?php

namespace App\Enums;

class TicketLogActions
{
    const CREATED = 'created';
    const STATUS_CHANGED = 'status_changed';
    const PRIORITY_CHANGED = 'priority_changed';
    const GROUP_CHANGED = 'group_changed';
    const AGENT_CHANGED = 'agent_changed';
    const INTERNAL_NOTE = 'internal_note';
    const PUBLIC_REPLY = 'public_reply';
    const ATTACHMENT = 'attachment_added';
    const RESOLVED = 'ticket_resolved';
    const REOPENED = 'ticket_reopened';
}