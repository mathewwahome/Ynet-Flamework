<?php

namespace Ynet;

abstract class ApiController
{
    protected $request;
    protected $response;
    
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        
        // Set JSON response headers by default
        $this->response->setHeader('Content-Type', 'application/json');
    }
    
    protected function success($data = null, $message = 'Success', $code = 200)
    {
        return $this->response->setStatusCode($code)->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }
    
    protected function error($message = 'Error', $code = 400, $errors = null)
    {
        return $this->response->setStatusCode($code)->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ]);
    }
}