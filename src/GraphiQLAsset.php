<?php

declare(strict_types=1);

namespace MLL\GraphiQL;

use Illuminate\Container\Container;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

class GraphiQLAsset
{
    public const REACT_JS_LOCAL_PATH = 'vendor/graphiql/react.production.min.js';
    public const REACT_JS_SOURCE_URL = 'https://cdn.jsdelivr.net/npm/react@18/umd/react.production.min.js';

    public const REACT_DOM_JS_LOCAL_PATH = 'vendor/graphiql/react-dom.production.min.js';
    public const REACT_DOM_JS_SOURCE_URL = 'https://cdn.jsdelivr.net/npm/react-dom@18/umd/react-dom.production.min.js';

    public const GRAPHIQL_CSS_LOCAL_PATH = 'vendor/graphiql/graphiql.min.css';
    public const GRAPHIQL_CSS_SOURCE_URL = 'https://cdn.jsdelivr.net/npm/graphiql@3/graphiql.min.css';

    public const FAVICON_LOCAL_PATH = 'vendor/graphiql/favicon.ico';
    public const FAVICON_SOURCE_URL = 'https://raw.githubusercontent.com/graphql/graphql.github.io/source/public/favicon.ico';

    public const GRAPHIQL_JS_LOCAL_PATH = 'vendor/graphiql/graphiql.min.js';
    public const GRAPHIQL_JS_SOURCE_URL = 'https://cdn.jsdelivr.net/npm/graphiql@3/graphiql.min.js';

    public const PLUGIN_EXPLORER_JS_LOCAL_PATH = 'vendor/graphiql/graphiql-plugin-explorer.umd.js';
    /** Pinned because the latest version broke, see https://github.com/mll-lab/laravel-graphiql/issues/25. */
    public const PLUGIN_EXPLORER_JS_SOURCE_URL = 'https://cdn.jsdelivr.net/npm/@graphiql/plugin-explorer@0.2.0/dist/index.umd.js';

    public static function reactJS(): string
    {
        return self::availableURL(self::REACT_JS_LOCAL_PATH, self::REACT_JS_SOURCE_URL);
    }

    public static function reactDOMJS(): string
    {
        return self::availableURL(self::REACT_DOM_JS_LOCAL_PATH, self::REACT_DOM_JS_SOURCE_URL);
    }

    public static function graphiQLCSS(): string
    {
        return self::availableURL(self::GRAPHIQL_CSS_LOCAL_PATH, self::GRAPHIQL_CSS_SOURCE_URL);
    }

    public static function favicon(): string
    {
        return self::availableURL(self::FAVICON_LOCAL_PATH, self::FAVICON_SOURCE_URL);
    }

    public static function graphiQLJS(): string
    {
        return self::availableURL(self::GRAPHIQL_JS_LOCAL_PATH, self::GRAPHIQL_JS_SOURCE_URL);
    }

    public static function pluginExplorerJS(): string
    {
        return self::availableURL(self::PLUGIN_EXPLORER_JS_LOCAL_PATH, self::PLUGIN_EXPLORER_JS_SOURCE_URL);
    }

    public static function publicPath(string $path): string
    {
        $container = Container::getInstance();
        assert($container instanceof LaravelApplication || $container instanceof LumenApplication);

        return $container->basePath("public/{$path}");
    }

    public static function localURL(string $path): string
    {
        $url = Container::getInstance()->make(UrlGenerator::class);

        return $url->asset($path);
    }

    public static function availableURL(string $local, string $cdn): string
    {
        return file_exists(self::publicPath($local))
            ? self::localURL($local)
            : $cdn;
    }
}
