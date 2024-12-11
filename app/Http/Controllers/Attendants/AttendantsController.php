<?php

namespace App\Http\Controllers\Attendants;

use App\Http\Controllers\Controller;
use App\Models\Chat\Chat;
use App\Services\Admin\AttendantsService;
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
        return view('admin.attendants.index');
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
        return view('admin.attendants.mychats');
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

    public function viewChat(Chat $chat)
    {
        $chatById = $chat->first();
        return view('admin.chat.initiate', compact('chatById'));
    }
}
