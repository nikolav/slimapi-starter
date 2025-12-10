<?php

namespace App\graphql\resolvers\mutation;

class DemoMutationResolver
{
  public function resolve($root, array $args = [])
  {
    return [
     'status' => 'demo:ok',
     'input'  => $args,
    ];
  }
}
