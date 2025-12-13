<?php

namespace App\graphql\resolvers\mutation;

use App\lib\TraitInstantiable;

class DemoMutationResolver
{
  use TraitInstantiable;

  public function resolve($root, array $args = [])
  {
    return [
     'status' => 'demo:ok',
     'input'  => $args,
    ];
  }
}
