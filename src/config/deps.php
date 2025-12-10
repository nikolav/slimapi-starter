<?php

use App\Service\Firebase;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
  $containerBuilder->addDefinitions([
    Firebase::class => function () { return Firebase::getInstance(); },
  ]);
};
