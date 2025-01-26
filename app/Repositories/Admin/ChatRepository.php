<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\ChatRepositoryInterface;
use App\Models\Chat\Chat;

class ChatRepository implements ChatRepositoryInterface
{
    protected $chat;

    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    public function all($term)
    {
        return $this->chat
            ->when($term, function ($query) use ($term) {
                return $query->where('protocol', 'like', '%' . $term . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function find($id)
    {
        return $this->chat
            ->find($id)
            ->first();
    }

    public function getChatById($id)
    {
        return $this->chat
            ->findOrFail($id);
    }
}
