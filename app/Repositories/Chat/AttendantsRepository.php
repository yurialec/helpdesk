<?php

namespace App\Repositories\Chat;

use App\Enums\ChatStatusEnum;
use App\Interfaces\Chat\AttendantsRepositoryInterface;
use App\Models\Chat\Chat;
use App\Models\Chat\ChatHistory;
use App\Models\Chat\ChatStatus;
use App\Models\Chat\Messages;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Log;

class AttendantsRepository implements AttendantsRepositoryInterface
{
    protected $attendants;
    protected $chats;

    public function __construct(User $attendants, Chat $chats)
    {
        $this->attendants = $attendants;
        $this->chats = $chats;
    }

    public function all($term): mixed
    {
        return $this->attendants
            ->with('chats')
            ->when($term, function ($query) use ($term) {
                return $query->where('name', 'like', '%' . $term . '%');
            })
            ->where('role_id', 5)
            ->paginate(10);
    }

    public function listMyChats($term)
    {
        $userId = Auth::user()->id;

        return $this->chats
            ->when($term, function ($query) use ($term) {
                return $query->where('protocol', 'like', '%' . $term . '%');
            })
            ->where('user_id', $userId)
            ->paginate(10);
    }

    public function chatById($id)
    {
        try {
            return $this->chats->find($id);
        } catch (Exception $err) {
            Log::error('Erro', [
                'message' => $err->getMessage()
            ]);
            return false;
        }
    }

    public function sendMessage($data, $protocol)
    {
        try {
            $chat = $this->chats->where('protocol', $protocol)->first();
            $chat->chat_status_id = ChatStatus::where('name', ChatStatusEnum::Ativo->value)->first()->id;
            $chat->save();

            $chatHistory = ChatHistory::create([
                'user_id' => Auth::id(),
                'activated_at' => Carbon::now(),
            ]);

            $chatId = $chat->id;

            $message = Messages::create([
                'message' => $data['message'],
                'user_id' => Auth::id(),
                'chat_id' => $chatId,
            ]);

            return $message;

        } catch (Exception $err) {

            Log::error('Erro ao enviar mensagem', ['erro' => $err->getMessage()]);
            return response()->json([
                'message' => 'Erro ao enviar mensagem'
            ], 204);
        }
    }
}
