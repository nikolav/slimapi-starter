<?php

declare(strict_types=1);

use App\Middleware\CorsMiddleware;
use App\Routes\RouteHome;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/config/env.php';

// Create App
$app = AppFactory::create();

// Optional: set base path if you’re not in web root
// $app->setBasePath('/my-slim-api/public');

// parse application/json body into an array
$app->addBodyParsingMiddleware();

// Handle OPTIONS preflight for any route
$app->options('/{routes:.+}', function ($request, $response) {
  return $response;
});

require __DIR__ . '/../src/config/db.php';

// routes:home
RouteHome::register($app);

// Add CORS middleware
$app->add(new CorsMiddleware());

// Run app
$app->run();
