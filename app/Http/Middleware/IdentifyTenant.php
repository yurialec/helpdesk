<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $subdomain = $request->route('tenancy');
        if ($subdomain) {
            $tenant = Tenant::where('domain', $subdomain)->first();

            if (!$tenant) {
                abort(404, 'Tenant não encontrado.');
            }

            // Defina o banco de dados do tenant aqui, se necessário.
            // Configuração dinâmica pode ser feita com tenancy.dev ou DB::purge / config(['database.connections.mysql.database' => ...])
            session(['tenant_id' => $tenant->id]);
            session(['domain' => $tenant->domain]);
        }
        return $next($request);
    }
}
