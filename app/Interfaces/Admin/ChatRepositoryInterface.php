<?php

namespace App\Interfaces\Admin;

interface ChatRepositoryInterface
{
    public function all($term);
    public function find($id);
    public function getChatById($id);
    public function transfer($chat_id, $user_id);
}
