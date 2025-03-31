<?php declare(strict_types=1);

namespace MLL\GraphiQL\Tests;

use MLL\GraphiQL\DownloadAssetsCommand;

final class DownloadAssetsCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $reactPublicPath = DownloadAssetsCommand::publicPath(DownloadAssetsCommand::REACT_PATH_LOCAL);
        if (file_exists($reactPublicPath)) {
            unlink($reactPublicPath);
        }
    }

    public function testSuccessfulDownload(): void
    {
        $reactPublicPath = DownloadAssetsCommand::publicPath(DownloadAssetsCommand::REACT_PATH_LOCAL);
        $this->assertFileDoesNotExist($reactPublicPath);
        $this->assertSame(DownloadAssetsCommand::REACT_PATH_CDN, DownloadAssetsCommand::reactPath());

        $this->artisan('graphiql:download-assets')
            ->assertOk();

        $this->assertFileExists($reactPublicPath);
        $this->assertSame(DownloadAssetsCommand::asset(DownloadAssetsCommand::REACT_PATH_LOCAL), DownloadAssetsCommand::reactPath());
    }
}
