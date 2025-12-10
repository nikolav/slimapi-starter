<?php

namespace App\Utils;

use Psr\Http\Message\ResponseInterface as Response;

class Utils
{
  /**
   * Write a JSON response.
   *
   * @param Response $response
   * @param mixed    $data
   * @param int      $code
   * @return Response
   */

  public static function json_response(Response $response, $data, int $code = 200): Response
  {
    $payload = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $response->getBody()->write($payload);

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($code);
  }
}
