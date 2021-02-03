<?php

namespace AzizSama\LaPermission\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware extends LaPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if(!$this->authorize('role', $role))
        {
            return $this->unauthorized();
        }

        return $next($request);
    }
}
