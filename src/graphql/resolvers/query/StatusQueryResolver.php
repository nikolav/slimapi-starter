<?php

namespace App\graphql\resolvers\query;

use App\lib\TraitInstantiable;

class StatusQueryResolver
{
  use TraitInstantiable;

  public function resolve($root, array $args = [])
  {
    return [
      'status' => 'ok',
      'args'   => $args,
    ];
  }

}
