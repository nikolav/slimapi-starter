<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareLogRequest
{
  private string $logFile;

  public function __construct()
  {
    // Default log location
    $this->logFile = __DIR__ . '/../../logs/' . $_ENV['LOG_REQUESTS_FILE'];

    // Ensure directory exists
    if (!is_dir(dirname($this->logFile))) {
      mkdir(dirname($this->logFile), 0777, true);
    }
  }

  public function __invoke(Request $request, RequestHandlerInterface $handler): Response
  {
    $start = microtime(true);

    // Capture basic request info
    $method = $request->getMethod();
    $uri    = (string)$request->getUri();
    $query  = $request->getQueryParams();

    // Optional: read request body (only for JSON)
    $body = null;
    if ($request->getHeaderLine('Content-Type') === 'application/json') {
      $body = json_encode($request->getParsedBody());
    }

    // Call next middleware / route handler
    $response = $handler->handle($request);

    $durationMs = round((microtime(true) - $start) * 1000, 2);

    // Response info
    $status = $response->getStatusCode();

    // Construct log message
    $log = sprintf(
      '[%s] %s %s %s | Status: %d | Time: %sms | Query: %s | Body: %s%s',
      date('Y-m-d H:i:s'),
      $method,
      $uri,
      php_sapi_name() === 'cli' ? '(CLI)' : '',
      $status,
      $durationMs,
      json_encode($query),
      $body ?: 'null',
      PHP_EOL
    );

    // Write to file
    file_put_contents($this->logFile, $log, FILE_APPEND);

    return $response;
  }
}
