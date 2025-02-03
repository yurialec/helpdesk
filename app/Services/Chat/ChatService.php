<?php

namespace App\Services\Chat;

use App\Repositories\Chat\ChatRepository;

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

    public function getChatById($id)
    {
        return $this->chatRepository->getChatById($id);
    }

    public function transfer($chat_id, $user_id)
    {
        return $this->chatRepository->transfer($chat_id, $user_id);
    }
}
