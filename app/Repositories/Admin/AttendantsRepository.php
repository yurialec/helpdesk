<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\AttendantsRepositoryInterface;
use App\Models\Chat\Chat;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;

class AttendantsRepository implements AttendantsRepositoryInterface
{
    protected $attendants;
    protected $chats;

    public function __construct(User $attendants, Chat $chats)
    {
        $this->attendants = $attendants;
        $this->chats = $chats;
    }

    public function all($term): mixed
    {
        return $this->attendants
            ->when($term, function ($query) use ($term) {
                return $query->where('name', 'like', '%' . $term . '%');
            })
            ->where('role_id', 5)
            ->paginate(10);
    }

    public function listMyChats($term)
    {
        $userId = Auth::user()->id;

        return $this->chats
            ->when($term, function ($query) use ($term) {
                return $query->where('protocol', 'like', '%' . $term . '%');
            })
            ->where('user_id', $userId)
            ->paginate(10);
    }
}