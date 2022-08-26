<?php declare(strict_types=1);

namespace MLL\GraphiQL;

use Illuminate\Console\Command;

class DownloadAssetsCommand extends Command
{
    public const REACT_PATH_LOCAL = 'vendor/graphiql/react.production.min.js';
    public const REACT_PATH_CDN = '//unpkg.com/react@18/umd/react.production.min.js';

    public const REACT_DOM_PATH_LOCAL = 'vendor/graphiql/react-dom.production.min.js';
    public const REACT_DOM_PATH_CDN = '//unpkg.com/react-dom@18/umd/react-dom.production.min.js';

    public const JS_PATH_LOCAL = 'vendor/graphiql/graphiql.min.js';
    public const JS_PATH_CDN = '//unpkg.com/graphiql/graphiql.min.js';

    public const CSS_PATH_LOCAL = 'vendor/graphiql/graphiql.min.css';
    public const CSS_PATH_CDN = '//unpkg.com/graphiql/graphiql.min.css';

    public const FAVICON_PATH_LOCAL = 'vendor/graphiql/favicon.ico';
    public const FAVICON_PATH_CDN = '//raw.githubusercontent.com/graphql/graphql.github.io/source/static/favicon.ico';

    protected $signature = 'graphiql:download-assets';

    protected $description = 'Download the newest version of the GraphiQL assets to serve them locally.';

    public function handle(): void
    {
        $this->fileForceContents(
            self::publicPath(self::REACT_PATH_LOCAL),
            file_get_contents('https:' . self::REACT_PATH_CDN)
        );
        $this->fileForceContents(
            self::publicPath(self::REACT_DOM_PATH_LOCAL),
            file_get_contents('https:' . self::REACT_DOM_PATH_CDN)
        );
        $this->fileForceContents(
            self::publicPath(self::CSS_PATH_LOCAL),
            file_get_contents('https:' . self::CSS_PATH_CDN)
        );
        $this->fileForceContents(
            self::publicPath(self::JS_PATH_LOCAL),
            file_get_contents('https:' . self::JS_PATH_CDN)
        );
        $this->fileForceContents(
            self::publicPath(self::FAVICON_PATH_LOCAL),
            file_get_contents('https:' . self::FAVICON_PATH_CDN)
        );
    }

    protected function fileForceContents(string $filePath, string $contents): void
    {
        // Ensure the directory exists
        $directory = dirname($filePath);
        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($filePath, $contents);
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
        return app('url')->asset($path);
    }

    protected static function publicPath(string $path): string
    {
        return app()->basePath("public/{$path}");
    }
}
