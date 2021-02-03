<?php

namespace AzizSama\LaPermission\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class LaPermissionMiddleware
{
    /**
     * Authorize
     * 
     * @param string $type
     * @param string $args
     */
    public function authorize($type, $args)
    {
        if(!is_array($args))
        {
            $args = explode("|", $args);
        }

        $method = $type === 'role' ? 'hasRole' : 'hasPermision';

        return !Auth::guard($type)->guest() && 
            Auth::guard($type)->user()->$method($args);
    }

    /**
     * Unauthorized
     */
    public function unauthorized()
    {
        $handling = Config::get('lapermission.middleware.handling');
        $config = Config::get("lapermission.middleware.handlers.$handling");
        if($handling === 'abort')
        {
            abort($config['code'], $config['message']);
        }
        else
        {
            return redirect($config['url'])->with($config['message']['key'], $config['message']['message']);
        }
    }
}