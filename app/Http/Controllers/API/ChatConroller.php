<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin\Client;
use App\Models\Chat\ChatHistory;
use App\Models\Chat\Conversation;
use App\Models\Chat\Message;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ChatConroller extends Controller
{
    public function store(Request $request)
    {
        if (!$request->cpf || !$request->email || !$request->telefone || !$request->responsavel) {
            return response()->json([
                'status' => false,
                'message' => 'Por favor informe o cpf/email/telefone/nome do responsavel'
            ]);
        }

        $clientData = [
            'cpf_cnpj' => $request->cpf,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'responsavel' => $request->responsavel,
        ];

        $client = Client::firstOrCreate(
            ['cpf_cnpj' => $clientData['cpf_cnpj']],
            $clientData
        );

        $conversation = new Conversation();
        $conversation->created_at = Carbon::now();
        $conversation->client_id = $client->id;
        $conversation->status = 'Ativa';
        $conversation->save();

        $chatHistory = new ChatHistory();
        $chatHistory->conversation_id = $conversation->id;
        $chatHistory->attendant_id = null;
        $chatHistory->save();

        // if (!empty($validatedData['message_content'])) {
        //     $message = new Message();
        //     $message->conversation_id = $conversation->id;
        //     $message->sender_id = $client->id;
        //     $message->sender_type = Client::class;
        //     $message->message_content = $validatedData['message_content'];
        //     $message->save();
        // }

        // try {
        //     $client = Client::firstOrCreate(
        //         ['cpf_cnpj' => $clientData['cpf_cnpj']],
        //         $clientData
        //     );

        //     // Criar uma nova conversa
        //     $conversation = new Conversation();
        //     $conversation->client_id = $client->id;
        //     $conversation->status = 'ativa';
        //     $conversation->save();

        //     // Criar o histórico de chat para a conversa
        //     $chatHistory = new ChatHistory();
        //     $chatHistory->conversation_id = $conversation->id;
        //     $chatHistory->attendant_id = null;
        //     $chatHistory->save();

        //     // Armazenar a primeira mensagem, se disponível
        //     if (!empty($validatedData['message_content'])) {
        //         $message = new Message();
        //         $message->conversation_id = $conversation->id;
        //         $message->sender_id = $client->id;
        //         $message->sender_type = Client::class;
        //         $message->message_content = $validatedData['message_content'];
        //         $message->save();
        //     }

        //     Log::info('Novo chat recebido', [
        //         'cliente' => [
        //             'id' => $client->id,
        //             'cpf_cnpj' => $client->cpf_cnpj,
        //             'email' => $client->email,
        //             'telefone' => $client->telefone,
        //             'responsavel' => $client->responsavel,
        //         ],
        //         'conversa' => [
        //             'id' => $conversation->id,
        //             'client_id' => $conversation->client_id,
        //             'status' => $conversation->status,
        //             'created_at' => $conversation->created_at,
        //             'updated_at' => $conversation->updated_at,
        //         ]
        //     ]);

        //     return response()->json(['success' => true, 'message' => 'Conversa iniciada com sucesso'], 201);
        // } catch (Exception $err) {

        //     Log::error('Erro ao iniciar o chat', ['erro' => $err->getMessage()]);

        //     return response()->json(['success' => false, 'message' => 'Erro ao iniciar o chat'], 500);
        // }
    }

}
