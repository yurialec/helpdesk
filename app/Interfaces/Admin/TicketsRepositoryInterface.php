<?php

namespace App\Interfaces\Admin;

interface TicketsRepositoryInterface
{
    public function all($term);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function listPriorities();
    public function listStatus();
    public function listAgents();
    public function listCompanies();
    public function listSystems($id);
    public function listSla();
    public function listCategory();
}