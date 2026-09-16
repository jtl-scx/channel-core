<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Helper;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use RuntimeException;

#[CoversClass(FileHandler::class)]
class FileHandlerTest extends TestCase
{
    private FileHandler $sut;
    private string $file;

    protected function setUp(): void
    {
        $this->sut = new FileHandler();
        $this->file = tempnam(sys_get_temp_dir(), 'file-handler-test');
    }

    protected function tearDown(): void
    {
        if (is_file($this->file)) {
            unlink($this->file);
        }
    }

    #[Test]
    public function it_writes_and_reads_a_file(): void
    {
        $content = uniqid('content', true);

        $resource = $this->sut->open($this->file, 'w+');
        $this->sut->write($resource, $content);
        $this->sut->close($resource);

        self::assertTrue($this->sut->isFile($this->file));
        self::assertSame($content, $this->sut->readContent($this->file));
    }

    #[Test]
    public function it_rewinds_an_open_file(): void
    {
        $resource = $this->sut->open($this->file, 'w+');
        $this->sut->write($resource, 'abc');

        self::assertTrue($this->sut->rewind($resource));
        self::assertSame('abc', fread($resource, 3));

        $this->sut->close($resource);
    }

    #[Test]
    public function it_removes_a_file(): void
    {
        self::assertTrue($this->sut->unlink($this->file));
        self::assertFalse($this->sut->isFile($this->file));
    }

    #[Test]
    public function it_fails_loudly_when_a_file_cannot_be_opened(): void
    {
        $this->expectException(RuntimeException::class);

        $this->sut->open(sys_get_temp_dir() . '/does/not/exist.txt', 'r');
    }

    #[Test]
    public function it_fails_loudly_when_a_file_cannot_be_read(): void
    {
        $this->expectException(RuntimeException::class);

        $this->sut->readContent(sys_get_temp_dir() . '/does/not/exist.txt');
    }
}
