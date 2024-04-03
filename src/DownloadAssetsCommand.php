<?php declare(strict_types=1);

namespace MLL\GraphiQL;

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

class DownloadAssetsCommand extends Command
{
    public const REACT_PATH_LOCAL = 'vendor/graphiql/react.production.min.js';
    public const REACT_PATH_CDN = '//unpkg.com/react@17/umd/react.production.min.js';

    public const REACT_DOM_PATH_LOCAL = 'vendor/graphiql/react-dom.production.min.js';
    public const REACT_DOM_PATH_CDN = '//unpkg.com/react-dom@17/umd/react-dom.production.min.js';

    public const JS_PATH_LOCAL = 'vendor/graphiql/graphiql.min.js';
    public const JS_PATH_CDN = '//unpkg.com/graphiql/graphiql.min.js';

    public const PLUGIN_EXPLORER_PATH_LOCAL = 'vendor/graphiql/graphiql-plugin-explorer.umd.js';
    /** Pinned because the latest version broke, see https://github.com/mll-lab/laravel-graphiql/issues/25. */
    public const PLUGIN_EXPLORER_PATH_CDN = '//unpkg.com/@graphiql/plugin-explorer@0.2.0/dist/index.umd.js';

    public const CSS_PATH_LOCAL = 'vendor/graphiql/graphiql.min.css';
    public const CSS_PATH_CDN = '//unpkg.com/graphiql/graphiql.min.css';

    public const FAVICON_PATH_LOCAL = 'vendor/graphiql/favicon.ico';
    public const FAVICON_PATH_CDN = '//raw.githubusercontent.com/graphql/graphql.github.io/source/public/favicon.ico';

    protected $signature = 'graphiql:download-assets';

    protected $description = 'Download the newest version of the GraphiQL assets to serve them locally.';

    public function handle(): void
    {
        $this->downloadFileFromCDN(self::REACT_PATH_LOCAL, self::REACT_PATH_CDN);
        $this->downloadFileFromCDN(self::REACT_DOM_PATH_LOCAL, self::REACT_DOM_PATH_CDN);
        $this->downloadFileFromCDN(self::CSS_PATH_LOCAL, self::CSS_PATH_CDN);
        $this->downloadFileFromCDN(self::JS_PATH_LOCAL, self::JS_PATH_CDN);
        $this->downloadFileFromCDN(self::PLUGIN_EXPLORER_PATH_LOCAL, self::PLUGIN_EXPLORER_PATH_CDN);
        $this->downloadFileFromCDN(self::FAVICON_PATH_LOCAL, self::FAVICON_PATH_CDN);
    }

    protected function downloadFileFromCDN(string $localPath, string $cdnPath): void
    {
        $publicPath = self::publicPath($localPath);

        // Ensure the directory exists
        $directory = dirname($publicPath);
        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $contents = file_get_contents("https:{$cdnPath}");
        if ($contents === false) {
            $error = error_get_last();
            throw new \ErrorException($error['message'] ?? 'An error occurred', 0, $error['type'] ?? 1);
        }

        file_put_contents($publicPath, $contents);
    }

    public static function reactPath(): string
    {
        return self::assetPath(self::REACT_PATH_LOCAL, self::REACT_PATH_CDN);
    }

    public static function reactDOMPath(): string
    {
        return self::assetPath(self::REACT_DOM_PATH_LOCAL, self::REACT_DOM_PATH_CDN);
    }

    public static function jsPath(): string
    {
        return self::assetPath(self::JS_PATH_LOCAL, self::JS_PATH_CDN);
    }

    public static function pluginExplorerPath(): string
    {
        return self::assetPath(self::PLUGIN_EXPLORER_PATH_LOCAL, self::PLUGIN_EXPLORER_PATH_CDN);
    }

    public static function cssPath(): string
    {
        return self::assetPath(self::CSS_PATH_LOCAL, self::CSS_PATH_CDN);
    }

    public static function faviconPath(): string
    {
        return self::assetPath(self::FAVICON_PATH_LOCAL, self::FAVICON_PATH_CDN);
    }

    protected static function assetPath(string $local, string $cdn): string
    {
        return file_exists(self::publicPath($local))
            ? self::asset($local)
            : $cdn;
    }

    protected static function asset(string $path): string
    {
        $url = Container::getInstance()->make(UrlGenerator::class);

        return $url->asset($path);
    }

    protected static function publicPath(string $path): string
    {
        $container = Container::getInstance();
        assert($container instanceof LaravelApplication || $container instanceof LumenApplication);

        return $container->basePath("public/{$path}");
    }
}
