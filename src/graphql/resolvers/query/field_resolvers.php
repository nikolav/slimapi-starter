<?php

use App\graphql\resolvers\query\StatusQueryResolver;

$statusQueryResolver = new StatusQueryResolver();

// export query resolvers
return [
  // fieldName => [resolverInstance, 'methodName']
 'status'  => [$statusQueryResolver, 'resolve'],
];
