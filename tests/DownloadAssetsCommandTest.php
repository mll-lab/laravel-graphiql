<?php declare(strict_types=1);

namespace MLL\GraphiQL\Tests;

use MLL\GraphiQL\DownloadAssetsCommand;

final class DownloadAssetsCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        foreach (self::paths() as [$localPath, $cdnPath]) {
            $publicPath = DownloadAssetsCommand::publicPath($localPath);
            if (file_exists($publicPath)) {
                unlink($publicPath);
            }
        }
    }

    public function testSuccessfulDownload(): void
    {
        foreach (self::paths() as [$localPath, $cdnPath]) {
            $this->assertFileDoesNotExist(DownloadAssetsCommand::publicPath($localPath));
            $this->assertSame(DownloadAssetsCommand::cdnURL($cdnPath), DownloadAssetsCommand::availablePath($localPath, $cdnPath));
        }

        $this->artisan('graphiql:download-assets')
            ->assertOk();

        foreach (self::paths() as [$localPath, $cdnPath]) {
            $this->assertFileExists(DownloadAssetsCommand::publicPath($localPath));
            $this->assertSame(DownloadAssetsCommand::localAssetURL($localPath), DownloadAssetsCommand::availablePath($localPath, $cdnPath));
        }
    }

    /** @return iterable<array{string, string}> */
    private static function paths(): iterable
    {
        yield [DownloadAssetsCommand::REACT_PATH_LOCAL, DownloadAssetsCommand::REACT_PATH_CDN];
        yield [DownloadAssetsCommand::REACT_DOM_PATH_LOCAL, DownloadAssetsCommand::REACT_DOM_PATH_CDN];
        yield [DownloadAssetsCommand::JS_PATH_LOCAL, DownloadAssetsCommand::JS_PATH_CDN];
        yield [DownloadAssetsCommand::PLUGIN_EXPLORER_PATH_LOCAL, DownloadAssetsCommand::PLUGIN_EXPLORER_PATH_CDN];
        yield [DownloadAssetsCommand::CSS_PATH_LOCAL, DownloadAssetsCommand::CSS_PATH_CDN];
        yield [DownloadAssetsCommand::FAVICON_PATH_LOCAL, DownloadAssetsCommand::FAVICON_PATH_CDN];
    }
}
