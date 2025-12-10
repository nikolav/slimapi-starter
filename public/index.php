<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Middleware\CorsMiddleware;

require __DIR__ . '/../vendor/autoload.php';

// Create App
$app = AppFactory::create();

// Optional: set base path if you’re not in web root
// $app->setBasePath('/my-slim-api/public');

// Handle OPTIONS preflight for any route
$app->options('/{routes:.+}', function ($request, $response) {
    return $response;
});

// Add CORS middleware
$app->add(new CorsMiddleware());



// Default root route
$app->get('/', function (Request $request, Response $response) {
    $data = [
        'status' => 'ok:2'
    ];

    $payload = json_encode($data, JSON_UNESCAPED_UNICODE);
    $response->getBody()->write($payload);

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

// Run app
$app->run();
