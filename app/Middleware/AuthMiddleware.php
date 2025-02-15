<?php

namespace App\Middleware;

use Ynet\Middleware;
use Ynet\Request;
use Ynet\Auth;

class AuthMiddleware extends Middleware
{
    protected $auth;
    
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }
    
    public function handle(Request $request, \Closure $next)
    {
        $authHeader = $request->headers['Authorization'] ?? '';
        
        if (empty($authHeader) || !preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
            return [
                'success' => false,
                'message' => 'Unauthorized: No token provided',
                'status_code' => 401
            ];
        }
        
        $token = $matches[1];
        $payload = $this->auth->validateToken($token);
        
        if (!$payload) {
            return [
                'success' => false,
                'message' => 'Unauthorized: Invalid token',
                'status_code' => 401
            ];
        }
        
        // Add user ID to the request
        $request->userId = $payload->user_id;
        
        return $next($request);
    }
}