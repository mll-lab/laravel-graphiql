<?php declare(strict_types=1);

namespace MLL\GraphiQL;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class GraphiQLServiceProvider extends ServiceProvider
{
    public const CONFIG_PATH = __DIR__ . '/graphiql.php';
    public const VIEW_PATH = __DIR__ . '/../views';

    public function boot(ConfigRepository $config): void
    {
        $this->loadViewsFrom(self::VIEW_PATH, 'graphiql');

        $this->publishes([
            self::CONFIG_PATH => $this->configPath('graphiql.php'),
        ], 'graphiql-config');

        $this->publishes([
            self::VIEW_PATH => $this->resourcePath('views/vendor/graphiql'),
        ], 'graphiql-view');

        if (! $config->get('graphiql.enabled', true)) {
            return;
        }

        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }

    protected function loadRoutesFrom($path): void
    {
        if (Str::contains($this->app->version(), 'Lumen')) {
            require realpath($path);

            return;
        }

        parent::loadRoutesFrom($path);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(self::CONFIG_PATH, 'graphiql');

        if ($this->app->runningInConsole()) {
            $this->commands([
                DownloadAssetsCommand::class,
            ]);
        }
    }

    protected function configPath(string $path): string
    {
        return $this->app->basePath("config/{$path}");
    }

    protected function resourcePath(string $path): string
    {
        return $this->app->basePath("resources/{$path}");
    }
}
