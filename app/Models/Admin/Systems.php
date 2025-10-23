<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Systems extends Model
{
    use HasFactory;

    protected $table = 'systems';

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'company_id',
        'active',
    ];

    public function category()
    {
        return $this->belongsTo(SystemCategories::class);
    }
}
