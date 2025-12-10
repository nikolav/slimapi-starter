<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
    'driver'    => 'mysql',     // mysql | pgsql | sqlite
    'host'      => 'localhost',
    'database'  => 'nikolav_ciqssdmlgww',
    'username'  => 'nikolav_uuvddqdiyuy',
    'password'  => 'fj8Yj8T7_n6BNp{y',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// ----------------------------------------
// Run all migrations
// ----------------------------------------

$migrationDir = __DIR__ . '/database/migrations';

$mode = $argv[1] ?? 'up';

foreach (glob($migrationDir . '/*.php') as $file) {
  echo "Running migration: $file\n";
  $migration = require $file;
  $migration->up();
}

echo "Migrations complete.\n";
