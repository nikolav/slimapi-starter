<?php

namespace App\lib;

use Slim\App;

interface InterfaceRoute
{
  /**
   * Register routes on the Slim application instance.
   *
   * Example:
   *   RouteHome::register($app);
   */
  public static function register(App $app): void;
}
