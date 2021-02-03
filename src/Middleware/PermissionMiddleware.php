<?php

namespace AzizSama\LaPermission\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware extends LaPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if(!$this->authorize('permission', $permission))
        {
            return $this->unauthorized();
        }

        return $next($request);
    }
}