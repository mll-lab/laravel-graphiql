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

        $context = stream_context_create(['http' => ['timeout' => 30]]);
        $contents = retry([1000, 2000, 4000], static function () use ($sourceURL, $context): string {
            $contents = @file_get_contents($sourceURL, false, $context);
            if ($contents === false) {
                $error = error_get_last();
                throw new \ErrorException($error['message'] ?? "Failed to download {$sourceURL}", 0, $error['type'] ?? 1);
            }

            return $contents;
        });

        file_put_contents($publicPath, $contents);
    }
}
