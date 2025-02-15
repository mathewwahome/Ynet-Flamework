<?php

use Ynet\Application;

return function (Application $app) {
    $app->router->get('/', function () use ($app) {
        $params = [
            'title' => 'Welcome to Ynet',
            'message' => 'Your lightweight PHP framework'
        ];

        return $app->view->render('home', $params);
    });

    $app->router->get('/about', function () use ($app) {
        return $app->view->render('about');
    });

    $app->router->get('/api/hello', function () use ($app) {
        return $app->response->json(['message' => 'Hello from Ynet API!']);
    });


    $app->router->get('/form-builder', function () use ($app) {
        return $app->view->render('form-builder/index');
    });

    $app->router->post('/form-builder/save', function () use ($app) {
        try {
            // Get JSON data from request
            $formData = json_decode(file_get_contents('php://input'), true);
            
            if (!$formData) {
                throw new \Exception('Invalid JSON input received');
            }
    
            // Initialize Form Generator
            $generator = new \Ynet\FormBuilder\FormGenerator($app->db);
            $generator->createForm($formData);
    
            return $app->response->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the error
            error_log('[ERROR] ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
    
            return $app->response->setStatusCode(500)->json([
                'success' => false,
                'error' => 'An internal error occurred. Please try again later.'
            ]);
        }
    });
    
};