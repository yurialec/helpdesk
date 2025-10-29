<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SystemCategory extends Model
{
    protected $table = 'system_categories';

    protected $fillable = [
        'name',
        'description',
        'active',
    ];
}