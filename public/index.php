<?php

declare(strict_types=1);

use App\Middleware\CorsMiddleware;
use App\Middleware\MiddlewareLogRequest;
use App\Routes\RouteGraphql;
use App\Routes\RouteHome;
use App\Utils\Utils;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/config/env.php';

// setup class resolving
$containerBuilder = new ContainerBuilder();
(require __DIR__ . '/../src/config/deps.php')($containerBuilder);

$container = $containerBuilder->build();
AppFactory::setContainer($container);

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

if (Utils::toBool($_ENV['DB_INIT'])) {
  require_once __DIR__ . '/../src/config/db.php';
}

// routes:home
RouteHome::register($app);

// routes:graphql
RouteGraphql::register($app);

// logging
if (Utils::toBool($_ENV['LOGGING_ENABLED'])) {
  $app->add(new MiddlewareLogRequest());
}

// Add CORS middleware
$app->add(new CorsMiddleware());

// Run app
$app->run();
