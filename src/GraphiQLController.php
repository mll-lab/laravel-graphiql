<?php declare(strict_types=1);

namespace MLL\GraphiQL;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GraphiQLController
{
    public function __construct(
        protected ViewFactory $viewFactory,
    ) {}

    public function __invoke(ConfigRepository $config, Request $request): View
    {
        // Handle /, /graphiql or graphiql
        $path = '/' . trim($request->path(), '/');

        $routeConfig = $config->get("graphiql.routes.{$path}")
            ?? throw new NotFoundHttpException("No graphiql route config found for '{$path}'.");
        assert(is_array($routeConfig));

        return $this->viewFactory->make('graphiql::index', [
            'url' => $this->maybeURL($routeConfig['endpoint'] ?? null),
            'subscriptionUrl' => $this->maybeURL($routeConfig['subscription-endpoint'] ?? null),
        ]);
    }

    protected function maybeURL(?string $endpoint): ?string
    {
        return is_string($endpoint) && filter_var($endpoint, FILTER_VALIDATE_URL)
            ? url($endpoint) // Avoid injecting UrlGenerator for Lumen compatibility
            : $endpoint;
    }
}
