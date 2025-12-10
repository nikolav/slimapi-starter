<?php

require __DIR__ . '/vendor/autoload.php';

// If DB is *not* booted elsewhere, you can uncomment and do DB setup here
// but since run-migrations.php already required config/database.php,
// you don't need to reconfigure Capsule here again.

// Path to migrations
$migrationDir = __DIR__ . '/database/migrations';

foreach (glob($migrationDir . '/*.php') as $file) {
  echo "Running migration: $file\n";
  $migration = require $file;
  $migration->up();
}

echo "Migrations complete.\n";
