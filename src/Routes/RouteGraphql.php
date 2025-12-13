<?php

namespace App\Routes;

use App\graphql\GraphQLServer;
use App\lib\InterfaceRoute;
use App\Utils\Utils;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

class RouteGraphql implements InterfaceRoute
{
  private static ?GraphQLServer $graphqlServer = null;

  /**
   * GraphQL server init once
   */
  private static function getServer(): GraphQLServer
  {
    if (self::$graphqlServer === null) {
      self::$graphqlServer = new GraphQLServer();
    }

    return self::$graphqlServer;
  }

  public static function register(App $app): void
  {
    // This is like: app.register_blueprint(users, url_prefix="/users")
    $app->post('/graphql', function (Request $request, Response $response) {
      $graphqlServer = RouteGraphql::getServer();

      $body = $request->getParsedBody() ?: [];

      $query         = $body['query']         ?? null;
      $variables     = $body['variables']     ?? null;
      $operationName = $body['operationName'] ?? null;

      if (!$query) {
        return Utils::json_response($response, [
            'errors' => [['message' => 'No query provided']],
        ], 400);
      }

      $result = $graphqlServer->handle($query, $variables, $operationName);

      return Utils::json_response($response, $result);
    });

  }
}
