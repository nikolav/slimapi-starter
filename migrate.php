<?php

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
