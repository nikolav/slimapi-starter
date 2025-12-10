<?php

namespace App\Service;

use Kreait\Firebase\Auth;
use Kreait\Firebase\Factory;

class Firebase
{
  private static ?Firebase $instance = null;
  private Auth $auth;

  private function __construct()
  {
    $serviceAccountFile = __DIR__ . '/../../src/config/firebase/service_account.json';

    $factory = (new Factory())
        ->withServiceAccount($serviceAccountFile);

    $this->auth = $factory->createAuth();
  }

  public static function getInstance(): Firebase
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  public function auth(): Auth
  {
    return $this->auth;
  }
}
