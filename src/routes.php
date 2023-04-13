<?php declare(strict_types=1);

use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use MLL\GraphiQL\GraphiQLController;

$app = Container::getInstance();

$config = $app->make(ConfigRepository::class);
assert($config instanceof ConfigRepository);

/** @var \Illuminate\Contracts\Routing\Registrar|\Laravel\Lumen\Routing\Router $router */
$router = $app->make('router');

/** @var array<string, array{name?: string, middleware?: string, prefix?: string, domain?: string}> $routesConfig */
$routesConfig = $config->get('graphiql.routes', []);

foreach ($routesConfig as $routeUri => $routeConfig) {
    $actions = ['uses' => GraphiQLController::class];

    if (isset($routeConfig['name'])) {
        $actions['as'] = $routeConfig['name'];
    }

    if (isset($routeConfig['middleware'])) {
        $actions['middleware'] = $routeConfig['middleware'];
    }

    if (isset($routeConfig['prefix'])) {
        $actions['prefix'] = $routeConfig['prefix'];
    }

    if (isset($routeConfig['domain'])) {
        $actions['domain'] = $routeConfig['domain'];
    }

    $router->get($routeUri, $actions);
}
