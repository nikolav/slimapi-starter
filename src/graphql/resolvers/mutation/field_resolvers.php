<?php

use App\graphql\resolvers\mutation\DemoMutationResolver;

$demoMutationResolver = new DemoMutationResolver();

// export mutation resolvers
return [
   // fieldName => [resolverInstance, 'methodName']
   'demo' => [$demoMutationResolver, 'resolve'],
];
