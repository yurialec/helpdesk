<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Chat\Clients;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return view('chat.clients.index');
    }

    public function list()
    {
        $clients = Clients::paginate();

        return response()->json([
            'clients' => $clients
        ]);
    }
}
