<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Chat\Chat;
use App\Services\Admin\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $chatService;
    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function index()
    {
        return view('admin.chat.index');
    }

    public function list(Request $request)
    {
        $chats = $this->chatService->getAll($request->input('search'));

        if ($chats) {
            return response()->json([
                'status' => true,
                'chats' => $chats
            ], 200);
        } else {
            return response()->json([
                'message' => 'Nenhum registro encontrado.',
                'status' => 204
            ]);
        }
    }

    public function initiate(Chat $chat)
    {
        $chatById = $chat->first();
        return view('admin.chat.initiate', compact('chatById'));
    }
}
