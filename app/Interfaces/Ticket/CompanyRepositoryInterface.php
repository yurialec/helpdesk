<?php

namespace App\Interfaces\Ticket;

interface CompanyRepositoryInterface
{
    public function all($term = null);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}