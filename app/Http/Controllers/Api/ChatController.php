<?php

namespace App\Http\Controllers\Api;

use App\Enums\ChatPriorityEnum;
use App\Enums\ChatStatusEnum;
use App\Events\NewMessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Chat\Chat;
use App\Models\Chat\ChatPriority;
use App\Models\Chat\ChatQueue;
use App\Models\Chat\ChatStatus;
use App\Models\Chat\Clients;
use App\Models\Chat\Messages;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Log;
use Str;

class ChatController extends Controller
{
    public function firstContact(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'cpf_cnpj' => 'required|string|max:20',
                'email' => 'required|email',
                'phone' => 'required|string|max:15',
                'name' => 'required|string|max:100',
            ]);

            $conversation = $this->validateConversation($validatedData);

            return response()->json([
                'status' => true,
                'protocolo' => $conversation,
            ], 200);

        } catch (Exception $e) {
            Log::error('Erro no chat', ['exception' => $e]);

            return response()->json([
                'status' => false,
                'message' => 'Erro ao iniciar a sessão. Por favor, tente novamente.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function validateConversation(array $clientData)
    {
        return DB::transaction(function () use ($clientData) {
            // Buscar ou criar o cliente
            $client = Clients::firstOrCreate(
                ['cpf_cnpj' => $clientData['cpf_cnpj']],
                [
                    'email' => $clientData['email'],
                    'phone' => $clientData['phone'],
                    'name' => $clientData['name'],
                ]
            );

            $clientId = $client->id;
            $protocol = $this->generateProtocol($client->id);
            $userId = $this->getAvailableUser();
            $status = ChatStatus::where('name', ChatStatusEnum::Pendente)->first()->id;

            $chat = Chat::create([
                'protocol' => $protocol,
                'client_id' => $client->id,
                'user_id' => $userId,
                'chat_status_id' => $status,
            ]);

            ChatQueue::create([
                'user_id' => $userId,
                'chat_id' => $chat->id,
                'priority_id' => ChatPriority::where('name', ChatPriorityEnum::Media->value)->first()->id,
            ]);

            return $chat->protocol;
        });
    }

    private function generateProtocol($clientId)
    {
        $formattedId = str_pad($clientId, 4, '0', STR_PAD_LEFT);
        $string = Str::upper(Str::random(6));
        return 'P' . date('m') . date('y') . $formattedId . $string;
    }

    public function sendMessage(Request $request, $protocol)
    {
        try {
            $chat = Chat::where('protocol', $protocol)->first();

            if (!$chat) {
                return response()->json([
                    'status' => false,
                    'message' => 'Protocolo inválido. Inicie o chat corretamente.',
                ], 400);
            }

            $validatedData = $request->validate([
                'message' => 'required|string',
                'attachment' => 'nullable|file',
            ]);

            // Armazenar o anexo, se enviado
            $attachmentPath = null;
            if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
                $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            }

            // Cria a mensagem
            $message = Messages::create([
                'message' => $validatedData['message'],
                'attachment' => $attachmentPath,
                'client_id' => $chat->client_id,
                'chat_id' => $chat->id,
            ]);

            broadcast(new NewMessageEvent($message))->toOthers();
            Log::info('Mensagem transmitida com sucesso', ['message_id' => $message->id]);

            $messages = Messages::where('chat_id', $chat->id)
                ->get();

            return response()->json([
                'status' => true,
                'data' => $messages,
            ], 200);

        } catch (Exception $e) {
            Log::error('Erro ao enviar mensagem', ['exception' => $e]);

            return response()->json([
                'status' => false,
                'message' => 'Erro ao enviar mensagem.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function getAvailableUser()
    {
        $user = DB::table('users')
            ->leftJoin('chats', 'users.id', '=', 'chats.user_id')
            ->select('users.id AS user_id')
            ->where('users.role_id', 5)
            ->groupBy('users.id')
            ->orderByRaw('COUNT(chats.id) ASC')
            ->orderBy('users.created_at', 'ASC')
            ->first();

        return $user ? $user->user_id : null;
    }
}
