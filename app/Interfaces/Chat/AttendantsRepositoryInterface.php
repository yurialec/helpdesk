<?php

namespace App\Interfaces\Chat;

interface AttendantsRepositoryInterface
{
    public function all($term);
    public function listMyChats($term);

    public function chatById($id);
}
