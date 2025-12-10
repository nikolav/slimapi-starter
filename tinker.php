<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/config/env.php';

use Ramsey\Uuid\Uuid;

echo Uuid::uuid4();
