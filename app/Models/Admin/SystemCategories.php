<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemCategories extends Model
{
    use HasFactory;

    protected $table = 'system_categories';

    protected $fillable = [
        'name',
        'description',
        'active',
    ];
}
