<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    
    const SERVICE_MANAGER_ID = 1;

    protected $fillable = [
        'name',
        'description',
        'level'
    ];

    protected $with = 'permissions';

    public function permissions()
    {
        return $this->hasManyThrough(
            Permissions::class, // O modelo final ao qual você está tentando acessar através da relação.
            PermissionsRoles::class, // O modelo intermediário que conecta Roles e Permissions.
            'role_id', // A chave estrangeira no modelo intermediário (PermissionsRoles) que referencia o modelo Roles.
            'id', // A chave estrangeira no modelo final (Permission) que referencia o modelo intermediário.
            'id', // A chave local no modelo Roles.
            'permission_id' // A chave local no modelo PermissionsRoles que referencia o modelo Permission.
        );
    }
}
