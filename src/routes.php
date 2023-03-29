<?php declare(strict_types=1);

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use MLL\GraphiQL\GraphiQLController;

$config = app(ConfigRepository::class);
assert($config instanceof ConfigRepository);

/**
 * Get the schema from the request and append to the configured endpoints.
 */
if ($schema = Str::afterLast(trim(Request::capture()->getPathInfo(), '/'), '/')) {
    $schema = '/' . $schema;
    if ($config->get('graphiql.route.uri') != $schema) {
        $config->set('graphiql.route.uri', $config->get('graphiql.route.uri') . $schema);
        $config->set('graphiql.endpoint', $config->get('graphiql.endpoint') . $schema);
    }
}

if ($routeConfig = $config->get('graphiql.route')) {
    /** @var \Illuminate\Contracts\Routing\Registrar|\Laravel\Lumen\Routing\Router $router */
    $router = app('router');

    $actions = [
        'as' => $routeConfig['name'] ?? 'graphiql',
        'uses' => GraphiQLController::class,
    ];

    if (isset($routeConfig['middleware'])) {
        $actions['middleware'] = $routeConfig['middleware'];
    }

    if (isset($routeConfig['prefix'])) {
        $actions['prefix'] = $routeConfig['prefix'];
    }

    if (isset($routeConfig['domain'])) {
        $actions['domain'] = $routeConfig['domain'];
    }

    $router->get(
        $routeConfig['uri'] ?? '/graphiql',
        $actions
    );
}
