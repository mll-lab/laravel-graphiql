<?php declare(strict_types=1);

namespace MLL\GraphiQL;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GraphiQLController
{
    public function __invoke(ConfigRepository $config, Request $request): View
    {
        $path = '/' . $request->path();

        $routeConfig = $config->get("graphiql.routes.{$path}");
        if (null === $routeConfig) {
            throw new NotFoundHttpException("No graphiql route config found for '{$path}'.");
        }

        return view('graphiql::index', ['routeConfig' => $routeConfig]);
    }
}
