<?php

use App\graphql\resolvers\query\StatusQueryResolver;

// export query resolvers
return [
 // fieldName => [resolverInstance, 'methodName']
 'status'  => [StatusQueryResolver::new(), 'resolve'],
];
