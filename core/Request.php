<?php

namespace Ynet;

class Request
{
    protected $get;
    protected $post;
    protected $server;
    protected $files;
    protected $headers;
    
    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
        $this->files = $_FILES;
        $this->headers = $this->parseHeaders();
    }
    
    protected function parseHeaders()
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))))] = $value;
            }
        }
        return $headers;
    }
    
    public function getMethod()
    {
        return $this->server['REQUEST_METHOD'];
    }
    
    public function getPath()
    {
        $path = $this->server['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }
        return $path;
    }
    
    // Additional methods for accessing request data
}