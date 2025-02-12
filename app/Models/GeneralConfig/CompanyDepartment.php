<?php

namespace App\Models\GeneralConfig;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDepartment extends Model
{
    use HasFactory;

    protected $table = 'company_department';

    protected $fillable = ['company_id', 'department_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
