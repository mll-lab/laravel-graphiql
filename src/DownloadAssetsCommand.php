<?php declare(strict_types=1);

namespace MLL\GraphiQL;

use Illuminate\Console\Command;

class DownloadAssetsCommand extends Command
{
    protected $signature = 'graphiql:download-assets';

    protected $description = 'Download the newest version of the GraphiQL assets to serve them locally.';

    public function handle(): void
    {
        $this->downloadFile(GraphiQLAsset::REACT_JS_LOCAL_PATH, GraphiQLAsset::REACT_JS_SOURCE_URL);
        $this->downloadFile(GraphiQLAsset::REACT_DOM_JS_LOCAL_PATH, GraphiQLAsset::REACT_DOM_JS_SOURCE_URL);
        $this->downloadFile(GraphiQLAsset::GRAPHIQL_CSS_LOCAL_PATH, GraphiQLAsset::GRAPHIQL_CSS_SOURCE_URL);
        $this->downloadFile(GraphiQLAsset::PLUGIN_EXPLORER_CSS_LOCAL_PATH, GraphiQLAsset::PLUGIN_EXPLORER_CSS_SOURCE_URL);
        $this->downloadFile(GraphiQLAsset::GRAPHIQL_JS_LOCAL_PATH, GraphiQLAsset::GRAPHIQL_JS_SOURCE_URL);
        $this->downloadFile(GraphiQLAsset::PLUGIN_EXPLORER_JS_LOCAL_PATH, GraphiQLAsset::PLUGIN_EXPLORER_JS_SOURCE_URL);
        $this->downloadFile(GraphiQLAsset::FAVICON_LOCAL_PATH, GraphiQLAsset::FAVICON_SOURCE_URL);
    }

    protected function downloadFile(string $localPath, string $sourceURL): void
    {
        $publicPath = GraphiQLAsset::publicPath($localPath);

        // Ensure the directory exists
        $directory = dirname($publicPath);
        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $contents = file_get_contents($sourceURL);
        if ($contents === false) {
            $error = error_get_last();
            throw new \ErrorException($error['message'] ?? 'An error occurred', 0, $error['type'] ?? 1);
        }

        file_put_contents($publicPath, $contents);
    }

    /** @deprecated use GraphiQLAsset::reactJS, this alias will be removed in the next major version */
    public static function reactPath(): string
    {
        return GraphiQLAsset::reactJS();
    }

    /** @deprecated use GraphiQLAsset::reactDOMJS, this alias will be removed in the next major version */
    public static function reactDOMPath(): string
    {
        return GraphiQLAsset::reactDOMJS();
    }

    /** @deprecated use GraphiQLAsset::graphiQLJS, this alias will be removed in the next major version */
    public static function jsPath(): string
    {
        return GraphiQLAsset::graphiQLJS();
    }

    /** @deprecated use GraphiQLAsset::pluginExplorerJS, this alias will be removed in the next major version */
    public static function pluginExplorerPath(): string
    {
        return GraphiQLAsset::pluginExplorerJS();
    }

    /** @deprecated use GraphiQLAsset::graphiQLCSS, this alias will be removed in the next major version */
    public static function cssPath(): string
    {
        return GraphiQLAsset::graphiQLCSS();
    }

    /** @deprecated use GraphiQLAsset::favicon, this alias will be removed in the next major version */
    public static function faviconPath(): string
    {
        return GraphiQLAsset::favicon();
    }
}
