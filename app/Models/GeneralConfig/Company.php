<?php

namespace App\Models\GeneralConfig;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'cnpj',
        'address',
        'email',
        'phone',
        'responsible_manager',
    ];

    public function departments()
    {
        return $this->hasManyThrough(
            Department::class,
            CompanyDepartment::class,
            'company_id',
            'id',
            'id',
            'department_id'
        );
    }
}