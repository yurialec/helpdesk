<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientChatController extends Controller
{
    public function showWidget()
    {
        return view('chat.widget');
    }
}
