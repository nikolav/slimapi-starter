<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
   'driver'    => $_ENV['DB_DRIVER'],
   'host'      => $_ENV['DB_HOST'],
   'port'      => $_ENV['DB_PORT'],
   'database'  => $_ENV['DB_DATABASE'],
   'username'  => $_ENV['DB_USERNAME'],
   'password'  => $_ENV['DB_PASSWORD'],
   'charset'   => $_ENV['DB_CHARSET'],
   'collation' => $_ENV['DB_COLLATION'],
   'prefix'    => '',
], 'default');

// Make Capsule available globally (optional but recommended)
$capsule->setAsGlobal();

// Boot Eloquent ORM
$capsule->bootEloquent();

return $capsule;
