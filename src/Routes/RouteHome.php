<?php

namespace App\Routes;

use App\lib\InterfaceRoute;
use App\Models\Main;
use App\Service\Firebase;
use App\Utils\Utils;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

class RouteHome implements InterfaceRoute
{
  public static function register(App $app): void
  {
    // This is like: app.register_blueprint(users, url_prefix="/users")
    $app->group('/', function (RouteCollectorProxy $group) {

      $group->get('', function (Request $request, Response $response) {
        $firebase = Firebase::getInstance();
        $auth     = $firebase->auth();

        $data = [
          'status'   => 'ok',
          'app:name' => $_ENV['APP_NAME'],
          'main:all' =>
            Utils::toBool($_ENV['DB_INIT'])
              ? Main::all()->toJson()
              : null,
          'auth:email' => $auth->getUser($_ENV['AUTH_TEST_UID'])->email,
        ];
        return Utils::json_response($response, $data);
      });

      // $group->post('foo', function (Request $request, Response $response) {
      //   $data = $request->getParsedBody() ?? [];
      //   return Utils::json_response($response, $data);
      // });
    });
  }
}
