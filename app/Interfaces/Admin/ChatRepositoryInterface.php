<?php

namespace App\Interfaces\Admin;

interface ChatRepositoryInterface
{
    public function all($term);
    public function find($id);
    public function getChatById($id);
}
