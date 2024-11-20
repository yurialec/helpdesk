<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Chat\Chat;
use App\Models\Chat\ChatStatus;
use App\Models\Chat\Clients;
use App\Models\Chat\Messages;
use DB;
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

        } catch (\Exception $e) {
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
            $formattedId = str_pad($clientId, 4, '0', STR_PAD_LEFT);
            $string = Str::upper(Str::random(6));
            $protocol = 'P' . date('m') . date('y') . $formattedId . $string;

            $chat = Chat::create([
                'protocol' => $protocol,
                'client_id' => $client->id,
                'chat_status_id' => ChatStatus::where('name', 'Ativo')->first()->id
            ]);

            return $chat->protocol;
        });
    }

    public function sendMessage(Chat $chat, Request $request)
    {
        try {
            // Verifica se o chat está ativo
            if ($chat->first()->chat_status_id) {

                $validatedData = $request->validate([
                    'message' => 'required|string',
                    'attachment' => 'nullable|file',
                ]);

                // Cria a mensagem
                $messageCreated = Messages::create([
                    'message' => $validatedData['message'],
                    'attachment' => $validatedData['attachment'] ?? null,
                    'client_id' => $chat->first()->client_id,
                    'chat_id' => $chat->first()->id,
                ]);

                // Retorna todas as mensagens do chat
                $messages = Messages::where('chat_id', $chat->first()->id)->get();

                return response()->json([
                    'status' => true,
                    'data' => $messages,
                ], 200);

            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Inicie o chat corretamente.',
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao enviar mensagem', ['exception' => $e]);

            return response()->json([
                'status' => false,
                'message' => 'Erro ao enviar mensagem.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
