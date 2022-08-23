<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use HBS\Helpers\FileSystemHelper;

final class FileSystemHelperTest  extends TestCase
{
    public function testBuildPath(): void
    {
        $path = FileSystemHelper::buildPath(["/home/user", "Documents", "Books", "Comics", "Marvel"]);

        $this->assertEquals("/home/user/Documents/Books/Comics/Marvel", $path);
    }
}
