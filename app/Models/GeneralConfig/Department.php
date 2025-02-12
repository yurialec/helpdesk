<?php

namespace App\Models\GeneralConfig;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'department';

    protected $fillable = ['company_id', 'name', 'description'];
}