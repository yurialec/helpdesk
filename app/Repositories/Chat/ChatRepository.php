<?php

namespace App\Repositories\CHAT;

use App\Enums\ChatStatusEnum;
use App\Interfaces\Chat\ChatRepositoryInterface;
use App\Models\Chat\Chat;
use App\Models\Chat\ChatStatus;
use Auth;
use Carbon\Carbon;
use Exception;
use Log;

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
        return $this->chat->find($id);
    }

    public function getChatById($id)
    {
        return $this->chat
            ->findOrFail($id);
    }

    public function transfer($chat_id, $user_id)
    {
        try {
            $chat = $this->chat->find($chat_id);
            $chat->user_id = $user_id;
            $chat->save();

            return true;
        } catch (Exception $err) {
            Log::error('Erro ao tranferir atendente', ['message' => $err->getMessage()]);
        }
    }

    public function end($id)
    {
        try {

            $chat = $this->chat->find($id);
            $chat->ended_at = Carbon::now();
            $chat->finished_id = Auth::id();
            $chat->chat_status_id = ChatStatus::where('name', ChatStatusEnum::Finalizado)->first()->id;
            $chat->save();

            return true;
        } catch (Exception $err) {
            Log::error('Erro ao finalizar chat', ['message' => $err->getMessage()]);
            return false;
        }
    }
}
