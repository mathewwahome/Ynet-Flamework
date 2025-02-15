<?php

namespace Ynet;

class Response
{
    protected $statusCode = 200;
    protected $headers = [];
    
    public function setStatusCode($code)
    {
        $this->statusCode = $code;
        return $this;
    }
    
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }
    
    public function send($content)
    {
        http_response_code($this->statusCode);
        
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
        
        echo $content;
        exit;
    }
    
    public function json($data)
    {
        $this->setHeader('Content-Type', 'application/json');
        return $this->send(json_encode($data));
    }
    
    public function notFound()
    {
        return $this->setStatusCode(404)->send('404 Not Found');
    }
}