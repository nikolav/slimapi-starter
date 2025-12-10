<?php

namespace App\graphql\resolvers\query;

class StatusQueryResolver
{
  public function resolve($root, array $args = [])
  {
    return [
      'status' => 'ok',
      'args'   => $args,
    ];
  }

}
