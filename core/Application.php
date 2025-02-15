<?php

namespace Ynet;

class Application
{
    protected $config;
    public $router;
    public $request;
    public $response;
    public $view;
    public $db;
    protected $middlewares = [];

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->router = new Router();
        $this->request = new Request();
        $this->response = new Response();
        $this->view = new View();

        if (isset($config['database'])) {
            $this->db = Database::getInstance($config['database']);
        }
        
        $this->loadRoutes();
    }

    protected function loadRoutes()
    {
        // Pass $this (Application instance) to the route file
        require YNET_ROOT . '/routes/web.php';
    }

    public function run()
    {
        try {
            $route = $this->router->resolve($this->request);
            
            if ($route) {
                $response = $this->executeRoute($route);
                $this->response->send($response);
            } else {
                $this->response->notFound();
            }
        } catch (\Exception $e) {
            // Basic error handling
            echo "Error: " . $e->getMessage();
        }
    }

    protected function executeRoute($route)
    {
        $handler = $route['handler'];
        $params = $route['params'] ?? [];

        if (is_callable($handler)) {
            return call_user_func($handler, ...$params);
        }
    }
}
