<?php

namespace App\Interfaces\Admin;

interface AttendantsRepositoryInterface
{
    public function all($term);
    public function listMyChats($term);

    public function chatById($id);
}
