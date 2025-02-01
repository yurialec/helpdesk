<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\RoleRepositoryInterface;
use App\Models\Admin\Permissions;
use App\Models\Admin\PermissionsRoles;
use App\Models\Admin\Roles;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Log;

class RoleRepository implements RoleRepositoryInterface
{
    protected $role;
    protected $permissionRoles;
    protected $permissions;

    public function __construct(Roles $role, PermissionsRolesRepository $permissionRoles, Permissions $permissions)
    {
        $this->role = $role;
        $this->permissionRoles = $permissionRoles;
        $this->permissions = $permissions;
    }

    public function all($term)
    {
        return $this->role
            ->when($term, function ($query) use ($term) {
                return $query->where('name', 'like', '%' . $term . '%');
            })
            ->where('id', '>=', Auth::user()->role_id)
            ->paginate(10);
    }

    public function find($id)
    {
        return $this->role->find($id);
    }

    public function create(array $data)
    {
        return $this->role->create($data);
    }

    public function update($id, $data)
    {
        $role = $this->role->find($id);
        if (!empty($role)) {

            try {
                DB::beginTransaction();

                foreach ($data['permissions'] as $key => $value) {
                    PermissionsRoles::create(
                        [
                            'permission_id' => $value,
                            'role_id' => $id,
                        ]
                    );
                }
                DB::commit();

                return response()->json([
                    true,
                ], 200);
            } catch (Exception $e) {
                DB::rollBack();
                Log::error('Erro ao cadastrar permissão no perfil: ' . $e->getMessage(), [
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Perfil não encontrado',
            ], 400);
        }
    }

    public function delete($id)
    {
        $role = $this->role->find($id);
        if ($role) {
            $role->delete();
            return true;
        }
        return false;
    }

    public function listPermissions()
    {
        return $this->permissions->get();
    }
}
