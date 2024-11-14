<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin\ChatHistory;
use App\Models\Admin\Client;
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

            $chatHistory = new ChatHistory();
            $chatHistory->client_id = $client->id;
            $chatHistory->save();

            Log::info('Novo chat recebido', ['cliente' => $client]);
        } catch (Exception $err) {
            Log::error('Erro no chat', ['erro' => $err]);
        }
    }
}
