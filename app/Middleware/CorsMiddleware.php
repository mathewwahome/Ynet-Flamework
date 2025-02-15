<?php

namespace Ynet\Middleware;

use Ynet\Middleware;
use Ynet\Request;

class CorsMiddleware extends Middleware
{
    public function handle(Request $request, \Closure $next)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        
        // Handle preflight requests
        if ($request->getMethod() === 'OPTIONS') {
            header('HTTP/1.1 204 No Content');
            exit();
        }
        
        return $next($request);
    }
}