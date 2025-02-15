<?php

define('YNET_START', microtime(true));
define('YNET_ROOT', dirname(__DIR__));

require YNET_ROOT . '/vendor/autoload.php';

$config = [
    'app' => require YNET_ROOT . '/config/app.php',
    'database' => require YNET_ROOT . '/config/database.php'
];

$app = new Ynet\Application($config);

// Update the loadRoutes method to use the returned function
$routeDefinitions = require YNET_ROOT . '/routes/web.php';
$routeDefinitions($app);

$app->run();