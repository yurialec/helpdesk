<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin\Client;
use App\Models\Chat\ChatHistory;
use App\Models\Chat\Conversation;
use App\Models\Chat\Message;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ChatConroller extends Controller
{
    public function store(Request $request)
    {
        $clientData = [
            'cpf_cnpj' => $request->cpf_cnpj,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'responsavel' => $request->responsavel,
        ];

        try {

            $client = Client::firstOrCreate(
                ['cpf_cnpj' => $clientData['cpf_cnpj']],
                $clientData
            );

            $conversation = new Conversation();
            $conversation->client_id = $client->id;
            $conversation->status = 'ativa';
            $conversation->save();

            $chatHistory = new ChatHistory();
            $chatHistory->conversation_id = $conversation->id;
            $chatHistory->attendant_id = null;
            $chatHistory->save();

            if ($request->has('message_content')) {
                $message = new Message();
                $message->conversation_id = $conversation->id;
                $message->sender_id = $client->id;
                $message->sender_type = Client::class;
                $message->message_content = $request->message_content;
                $message->save();
            }

            Log::info('Novo chat recebido', ['cliente' => $client, 'conversa' => $conversation]);

            return response()->json(['success' => true, 'message' => 'Conversa iniciada com sucesso'], 201);
        } catch (Exception $err) {
            return response()->json(['success' => false, 'message' => 'Erro ao iniciar o chat'], 500);
        }
    }
}
