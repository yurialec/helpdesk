<?php

namespace App\Services\Admin;

use App\Repositories\Admin\ChatRepository;


class ChatService
{
    protected $chatRepository;

    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    public function getAll($term)
    {
        return $this->chatRepository->all($term);
    }

    public function getById($id)
    {
        return $this->chatRepository->find($id);
    }
}
