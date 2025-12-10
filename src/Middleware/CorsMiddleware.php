<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CorsMiddleware
{
  public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    $response = $handler->handle($request);

    $response = $response
        ->withHeader('Access-Control-Allow-Origin', $_ENV['CORS_ALLOW_ORIGIN'])
        ->withHeader('Access-Control-Allow-Headers', $_ENV['CORS_ALLOW_HEADERS'])
        ->withHeader('Access-Control-Allow-Methods', $_ENV['CORS_ALLOW_METHODS']);

    if ($request->getMethod() === 'OPTIONS') {
      return $response->withStatus(200);
    }

    return $response;
  }
}
