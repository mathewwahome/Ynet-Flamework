<?php

/** @var \Ynet\Application $app */
global $app; // Get global instance of Application

$app->router->get('/api/v1/user', function () use ($app) {
    $users = [
        ['id' => 1, 'name' => 'John Doe'],
        ['id' => 2, 'name' => 'Jane Smith'],
    ];

    return $app->response->json([
        'success' => true,
        'data' => $users
    ]);
});

$app->router->post('/api/v1/login', function () use ($app) {
    $email = $app->request->post['email'] ?? null;
    $password = $app->request->post['password'] ?? null;

    // Authentication logic
    if ($email === 'test@example.com' && $password === 'password') {
        return $app->response->json([
            'success' => true,
            'token' => 'sample_jwt_token_here',
            'user' => ['id' => 1, 'email' => 'test@example.com']
        ]);
    }

    return $app->response->setStatusCode(401)->json([
        'success' => false,
        'message' => 'Invalid credentials'
    ]);
});
