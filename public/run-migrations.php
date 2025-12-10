<?php

$secret = '122333';

if (!isset($_GET['token']) || $_GET['token'] !== $secret) {
  http_response_code(403);
  echo 'Forbidden';
  exit;
}

require __DIR__ . '/../migrate.php';

echo 'Migrations executed.';
