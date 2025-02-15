<?php

use Ynet\Application;

return function(Application $app) {
    $app->router->get('/', function() use ($app) {
        $params = [
            'title' => 'Welcome to Ynet',
            'message' => 'Your lightweight PHP framework'
        ];
        
        return $app->view->render('home', $params);
    });

    $app->router->get('/about', function() use ($app) {
        return $app->view->render('about');
    });

    $app->router->get('/api/hello', function() use ($app) {
        return $app->response->json(['message' => 'Hello from Ynet API!']);
    });
};