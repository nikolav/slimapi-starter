<?php

namespace App\graphql;

use GraphQL\GraphQL;
use GraphQL\Type\Definition\CustomScalarType;
use GraphQL\Type\Schema;
use GraphQL\Utils\BuildSchema;

class GraphQLServer
{
  private Schema $schema;

  public function __construct()
  {
    $sdl = file_get_contents(__DIR__ . '/schema.graphql');

    // load query & mutation resolver maps from field_resolvers.php
    $queryFieldResolvers = $this->loadFieldResolvers(__DIR__ . '/resolvers/query/field_resolvers.php');
    $mutationFieldResolvers = $this->loadFieldResolvers(__DIR__ . '/resolvers/mutation/field_resolvers.php');

    $this->schema = BuildSchema::build(
      $sdl,
      function (array $typeConfig, $typeDefinitionNode) use ($queryFieldResolvers, $mutationFieldResolvers) {
        $name = $typeConfig['name'] ?? null;

        // attach resolvers to Query type
        if ($name === 'Query') {
          $fields = $typeConfig['fields'];

          $typeConfig['fields'] = function () use ($fields, $queryFieldResolvers) {
            $resolvedFields = \is_callable($fields) ? $fields() : $fields;

            foreach ($queryFieldResolvers as $fieldName => $resolver) {
              if (isset($resolvedFields[$fieldName])) {
                $resolvedFields[$fieldName]['resolve'] = $resolver;
              }
            }

            return $resolvedFields;
          };
        }

        // attach resolvers to Mutation type
        if ($name === 'Mutation') {
          $fields = $typeConfig['fields'];

          $typeConfig['fields'] = function () use ($fields, $mutationFieldResolvers) {
            $resolvedFields = \is_callable($fields) ? $fields() : $fields;

            foreach ($mutationFieldResolvers as $fieldName => $resolver) {
              if (isset($resolvedFields[$fieldName])) {
                $resolvedFields[$fieldName]['resolve'] = $resolver;
              }
            }

            return $resolvedFields;
          };
        }

        // custom JSON scalar
        if ($name === 'JSON') {
          return new CustomScalarType([
              'name' => 'JSON',
              'serialize' => fn ($value) => $value,
              'parseValue' => fn ($value) => $value,
              'parseLiteral' => function ($valueNode) {
                return property_exists($valueNode, 'value') ? $valueNode->value : null;
              },
          ]);
        }

        return $typeConfig;
      }
    );
  }

  /**
   * Safe loader for field_resolvers.php files.
   *
   * @param string $path
   * @return array<string, callable>
   */
  private function loadFieldResolvers(string $path): array
  {
    if (!file_exists($path)) {
      return [];
    }

    $resolvers = require $path;

    return \is_array($resolvers) ? $resolvers : [];
  }

  public function getSchema(): Schema
  {
    return $this->schema;
  }

  public function handle(string $query, ?array $variables = null, ?string $operationName = null): array
  {
    try {
      $result = GraphQL::executeQuery(
        $this->schema,
        $query,
        null,
        null,
        $variables,
        $operationName
      );

      return $result->toArray(true);
    } catch (\Throwable $e) {
      return [
          'errors' => [
              [
                  'message' => $e->getMessage(),
                  'trace'   => $e->getTraceAsString(), // hide in production
              ],
          ],
      ];
    }
  }
}
