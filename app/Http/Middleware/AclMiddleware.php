<?php

namespace App\Http\Middleware;

use App\Models\Admin\Roles;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AclMiddleware
{
    public function handle(Request $request, Closure $next, $permission = null)
    {
        if (session('role_id') === Roles::SERVICE_MANAGER_ID) {
            return $next($request);
        }

        if (in_array($permission, session('permissions'))) {
            return $next($request);
        }

        return redirect()
            ->route('home')
            ->withErrors([
                'message' => 'Você não tem permissão para acessar essa funcionalidade.'
            ]);
    }
}
