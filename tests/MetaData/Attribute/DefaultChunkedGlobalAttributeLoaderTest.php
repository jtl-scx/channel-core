<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * Class DefaultChunkedGlobalAttributeLoaderTest
 * @package JTL\SCX\Lib\Channel\MetaData\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\DefaultChunkedGlobalAttributeLoader
 */
class DefaultChunkedGlobalAttributeLoaderTest extends TestCase
{
    public function testTellsTheChannelWhatToImplement(): void
    {
        $sut = new DefaultChunkedGlobalAttributeLoader();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('ChunkedGlobalAttributeLoader');

        iterator_to_array($sut->loadChunked());
    }
}
