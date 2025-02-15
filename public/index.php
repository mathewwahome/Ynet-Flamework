<?php

define('YNET_START', microtime(true));
define('YNET_ROOT', dirname(__DIR__));

require YNET_ROOT . '/vendor/autoload.php';

$config = require YNET_ROOT . '/config/app.php';

$app = new Ynet\Application($config);

// Update the loadRoutes method to use the returned function
$routeDefinitions = require YNET_ROOT . '/routes/web.php';
$routeDefinitions($app);

$app->run();