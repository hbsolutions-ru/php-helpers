<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use HBS\Helpers\FileSystemHelper;
use HBS\Helpers\StringHelper;

final class FileSystemHelperTest extends TestCase
{
    public function testBuildPath(): void
    {
        $path = FileSystemHelper::buildPath(["/home/user", "Documents", "Books", "Comics", "Marvel"]);

        $this->assertEquals("/home/user/Documents/Books/Comics/Marvel", $path);
    }

    public function testGenerateFilenameIsRandom(): void
    {
        $path1 = FileSystemHelper::generateFilename("/home/user", "txt", 32);
        $path2 = FileSystemHelper::generateFilename("/home/user", "txt", 32);

        $this->assertFalse($path1 === $path2, "You are very lucky!");
    }

    public function testGenerateFilenameWithPathPrefix(): void
    {
        $path = FileSystemHelper::generateFilename("/home/user", "txt", 8);

        $this->assertStringStartsWith("/home/user/", $path);
        $this->assertStringEndsWith(".txt", $path);

        $filename = StringHelper::getLastPart('/', $path);

        $this->assertEquals(12, strlen($filename));
        $this->assertStringEndsWith(".txt", $filename);
    }
}
