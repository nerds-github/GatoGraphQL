# Release Notes: 2.1

## Added

### Support passing the Schema Configuration to apply when invoking the Internal GraphQL Server

Gato GraphQL now supports indicating what Schema Configuration to apply when executing a query via an internal GraphQL Server (i.e. directly within the PHP application, not via an endpoint).

The [Internal GraphQL Server extension](https://gatographql.com/extensions/internal-graphql-server/) makes use of this feature. It now accepts a `$schemaConfigurationIDOrSlug` parameter on `GraphQLServer::executeQuery` and `GraphQLServer::executeQueryInFile`, and already provides the persisted query's schema configuration on `GraphQLServer::executePersistedQuery`:

```diff
class GraphQLServer {
  
  public static function executeQuery(
    string $query,
    array $variables = [],
    ?string $operationName = null,
+   // Accept parameter 
+   int|string|null $schemaConfigurationIDOrSlug = null,
  ): Response {
    // ...
  }

  public static function executeQueryInFile(
    string $file,
    array $variables = [],
    ?string $operationName = null,
+   // Accept parameter 
+   int|string|null $schemaConfigurationIDOrSlug = null,
  ): Response {
    // ...
  }

+ // Schema Configuration is taken from the Persisted Query
  public static function executePersistedQuery(
    string|int $persistedQueryIDOrSlug,
    array $variables = [],
    ?string $operationName = null,
  ): Response {
    // ...
  }
```

### Predefined persisted query "Insert block in post"

The newly-added persisted GraphQL query "Insert block in post" allows to inject a block in a post. It identifies the nth block of a given type (`wp:paragraph` by default) in a post, and places the provided custom block's HTML content right after it.

Used with the [Automation](https://gatographql.com/extensions/automation/) extension, this persisted query can be used to automatically inject mandatory blocks to a newly-published post (eg: a CTA block to promote an ongoing campaign).

## Improvements

- If initializing the service container from the cache fails, fallback to initializing PHP object from memory (#2638)
- Give unique operationName to all predefined persisted queries (#2644)
- Improved error message when fetching blocks from a post, and the block content has errors

## Fixed

- Bug in multi-control JS component used by extensions (Access Control, Cache Control, and Field Deprecation) showing "undefined" on the block on the Schema Configuration (#2639)
- Avoid reinstalling plugin setup data if deactivating/reactivating the plugin (#2641)