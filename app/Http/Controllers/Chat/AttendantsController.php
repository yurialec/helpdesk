<?php

namespace App\Http\Controllers\Chat;

use App\Enums\ChatStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Chat\Chat;
use App\Models\Chat\ChatStatus;
use App\Services\Chat\AttendantsService;
use Auth;
use Illuminate\Http\Request;

class AttendantsController extends Controller
{
    protected $attendantService;
    public function __construct(AttendantsService $attendantService)
    {
        $this->attendantService = $attendantService;
    }

    public function index()
    {
        return view('chat.attendants.index');
    }

    public function list(Request $request)
    {
        $attendants = $this->attendantService->getAll($request->input('search'));

        if ($attendants) {
            return response()->json([
                'status' => true,
                'attendants' => $attendants
            ], 200);
        } else {
            return response()->json([
                'message' => 'Nenhum registro encontrado.',
                'status' => 204
            ]);
        }
    }

    public function myChats()
    {
        return view('chat.attendants.mychats');
    }

    public function listMyChats(Request $request)
    {
        $chats = $this->attendantService->listMyChats($request->input('search'));

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

    public function viewChat($id)
    {
        return view('chat.attendants.viewchat', compact('id'));
    }

    public function getChatById($id)
    {
        $chatById = $this->attendantService->getChatById($id);

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

    public function sendMessage(Request $request, $protocol)
    {
        $chat = Chat::where('protocol', $protocol)->first();

        $validatedData = $request->validate([
            'message' => 'required|string',
        ]);

        $chat->chat_status_id = ChatStatus::where('name', ChatStatusEnum::Ativo->value)->first()->id;
        $chat->save();

        $message = $chat->messages()->create([
            'message' => $validatedData['message'],
            'user_id' => Auth::id(),
            'chat_id' => $chat->id,
        ]);

        return response()->json([
            'data' => $message
        ], 201);
    }
}
