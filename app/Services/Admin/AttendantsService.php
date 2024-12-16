<?php

namespace App\Services\Admin;

use App\Repositories\Admin\AttendantsRepository;
use Illuminate\Support\Facades\Auth;

class AttendantsService
{
    protected $attendantsRepository;

    public function __construct(AttendantsRepository $attendantsRepository)
    {
        $this->attendantsRepository = $attendantsRepository;
    }

    public function getAll($term)
    {
        return $this->attendantsRepository->all($term);
    }

    public function listMyChats($term)
    {
        return $this->attendantsRepository->listMyChats($term);
    }

    public function chatById($id)
    {
        return $this->attendantsRepository->chatById($id);
    }
}
