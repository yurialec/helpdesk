<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AclMiddleware
{
    protected $except = [
        'users.index',
        'users.update',
        'users.store',

        'roles.index',
        'roles.update',
        'roles.store',

        'permissions.index',
        'permissions.update',
        'permissions.store',

        'menu.index',
        'menu.update',
        'menu.store',

        'site.logo.index',
        'site.logo.update',
        'site.logo.store',

        'profile',
        'profile.view',
        'modules.list',
    ];

    public function handle(Request $request, Closure $next)
    {
        $routeName = Route::currentRouteName();

        if (in_array($routeName, $this->except)) {
            return $next($request);
        }

        $permissions = $request->user()->role->permissions->pluck('name')->toArray();

        if (!in_array($routeName, $permissions) and $request->user()->role->name != 'Desenvolvedor') {
            return redirect()
                ->route('home')
                ->withErrors([
                    'message' => 'Você não tem permissão para acessar essa funcionalidade'
                ]);
        }

        return $next($request);
    }
}
