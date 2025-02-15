<?php

namespace Ynet;

class Router
{
    protected $routes = [];
    
    public function add($method, $path, $handler)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
        return $this;
    }
    
    public function get($path, $handler)
    {
        return $this->add('GET', $path, $handler);
    }
    
    public function post($path, $handler)
    {
        return $this->add('POST', $path, $handler);
    }
    
    // Add other HTTP methods...
    
    public function resolve(Request $request)
    {
        $method = $request->getMethod();
        $path = $request->getPath();
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($route['path'], $path, $params)) {
                return [
                    'handler' => $route['handler'],
                    'params' => $params
                ];
            }
        }
        
        return null;
    }
    
    protected function matchPath($routePath, $requestPath, &$params)
    {
        // Simple path matching logic
        // This could be enhanced with regex pattern matching for parameters
        if ($routePath === $requestPath) {
            $params = [];
            return true;
        }
        
        return false;
    }
}