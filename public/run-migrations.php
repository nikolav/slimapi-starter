<?php

$exit   = 1;
$secret = '122333';

if ($exit || (!isset($_GET['token']) || $_GET['token'] !== $secret)) {
  http_response_code(403);
  echo 'Forbidden';
  exit;
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/config/env.php';
$capsule = require_once __DIR__ . '/../src/config/db.php';

// Run migrations script (NO Slim here)
require __DIR__ . '/../migrate.php';

$capsule->getConnection()->disconnect();

echo "Migrations executed.\n";
