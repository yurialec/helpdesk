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

    public function view($id)
    {
        return view('admin.chat.view', compact('id'));
    }

    public function getChatById($id)
    {
        $chatById = $this->chatService->getChatById($id);

        if ($chatById) {
            return response()->json([
                'status' => true,
                'chatById' => $chatById
            ], 200);
        } else {
            return response()->json([
                'message' => 'Nenhum registro encontrado.',
                'status' => 204
            ]);
        }
    }
}
