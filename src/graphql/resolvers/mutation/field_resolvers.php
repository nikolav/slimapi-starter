<?php

use App\graphql\resolvers\mutation\DemoMutationResolver;

// export mutation resolvers
return [
  // fieldName => [resolverInstance, 'methodName']
   'demo' => [DemoMutationResolver::new(), 'resolve'],
];
