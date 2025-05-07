<?php declare(strict_types=1);

namespace MLL\GraphiQL\Tests;

use MLL\GraphiQL\GraphiQLAsset;

final class DownloadAssetsCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        foreach (self::localPathToSourceURL() as [$localPath, $cdnPath]) {
            $publicPath = GraphiQLAsset::publicPath($localPath);
            if (file_exists($publicPath)) {
                unlink($publicPath);
            }
        }
    }

    public function testSuccessfulDownload(): void
    {
        foreach (self::localPathToSourceURL() as [$localPath, $sourceURL]) {
            $this->assertFileDoesNotExist(GraphiQLAsset::publicPath($localPath));
            $this->assertSame($sourceURL, GraphiQLAsset::availableURL($localPath, $sourceURL));
        }

        $this->artisan('graphiql:download-assets')
            ->assertOk();

        foreach (self::localPathToSourceURL() as [$localPath, $sourceURL]) {
            $this->assertFileExists(GraphiQLAsset::publicPath($localPath));
            $this->assertSame(GraphiQLAsset::localURL($localPath), GraphiQLAsset::availableURL($localPath, $sourceURL));
        }
    }

    /** @return iterable<array{string, string}> */
    private static function localPathToSourceURL(): iterable
    {
        yield [GraphiQLAsset::REACT_JS_LOCAL_PATH, GraphiQLAsset::REACT_JS_SOURCE_URL];
        yield [GraphiQLAsset::REACT_DOM_JS_LOCAL_PATH, GraphiQLAsset::REACT_DOM_JS_SOURCE_URL];
        yield [GraphiQLAsset::GRAPHIQL_CSS_LOCAL_PATH, GraphiQLAsset::GRAPHIQL_CSS_SOURCE_URL];
        yield [GraphiQLAsset::PLUGIN_EXPLORER_CSS_LOCAL_PATH, GraphiQLAsset::PLUGIN_EXPLORER_CSS_SOURCE_URL];
        yield [GraphiQLAsset::FAVICON_LOCAL_PATH, GraphiQLAsset::FAVICON_SOURCE_URL];
        yield [GraphiQLAsset::GRAPHIQL_JS_LOCAL_PATH, GraphiQLAsset::GRAPHIQL_JS_SOURCE_URL];
        yield [GraphiQLAsset::PLUGIN_EXPLORER_JS_LOCAL_PATH, GraphiQLAsset::PLUGIN_EXPLORER_JS_SOURCE_URL];
    }
}
