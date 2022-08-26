<?php declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Route configuration
    |--------------------------------------------------------------------------
    |
    | Set the URI at which the GraphiQL UI can be viewed,
    | and add any additional configuration for the route.
    |
    */

    'route' => [
        'uri' => '/graphiql',
        'name' => 'graphiql',
        // 'middleware' => ['web']
        // 'prefix' => '',
        // 'domain' => 'graphql.' . env('APP_DOMAIN', 'localhost'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default GraphQL endpoint
    |--------------------------------------------------------------------------
    |
    | The default endpoint that the GraphiQL UI is set to.
    | It assumes you are running GraphQL on the same domain
    | as GraphiQL, but can be set to any URL.
    |
    */

    'endpoint' => '/graphql',

    /*
    |--------------------------------------------------------------------------
    | Control GraphiQL availability
    |--------------------------------------------------------------------------
    |
    | Control if the GraphiQL UI is accessible at all.
    | This allows you to disable it in certain environments,
    | for example you might not want it active in production.
    |
    */

    'enabled' => env('GRAPHIQL_ENABLED', true),
];
