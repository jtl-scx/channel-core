<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-12-27
 */

namespace JTL\SCX\Lib\Channel\MetaData\Price;

use InvalidArgumentException;
use JTL\SCX\Lib\Channel\Client\Model\PriceType;
use JTL\SCX\Lib\Channel\Helper\FileHandler;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\MetaData\Price\PriceTypeLoader
 */
class PriceTypeLoaderTest extends TestCase
{
    public function testCanLoad(): void
    {
        $fileName = uniqid('filename', true);
        $priceId = uniqid('priceId', true);
        $displayName = uniqid('displayName', true);
        $description = uniqid('description', true);
        $json = sprintf(
            '[{"priceId": "%s", "displayName": "%s", "description": "%s"}]',
            $priceId,
            $displayName,
            $description
        );

        $fileHandlerMock = $this->createMock(FileHandler::class);
        $fileHandlerMock->expects($this->atLeastOnce())->method('isFile')->with($fileName)->willReturn(true);
        $fileHandlerMock->expects($this->atLeastOnce())->method('readContent')->with($fileName)->willReturn($json);

        $loader = new PriceTypeLoader($fileHandlerMock);
        $result = $loader->load($fileName);

        $this->assertInstanceOf(PriceTypeList::class, $result);
        $this->assertSame(1, $result->count());
        /** @var PriceType $price */
        $price = $result->offsetGet(0);
        $this->assertInstanceOf(PriceType::class, $price);
        $this->assertSame($priceId, $price->getPriceTypeId());
        $this->assertSame($displayName, $price->getDisplayName());
        $this->assertSame($description, $price->getDescription());
    }

    public function testCanFailWithoutValidFile(): void
    {
        $fileName = uniqid('filename', true);

        $fileHandlerMock = $this->createMock(FileHandler::class);
        $fileHandlerMock->expects($this->atLeastOnce())->method('isFile')->with($fileName)->willReturn(false);

        $loader = new PriceTypeLoader($fileHandlerMock);
        $this->expectException(InvalidArgumentException::class);
        $loader->load($fileName);
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testCanFailWithoutValidData($json): void
    {
        $fileName = uniqid('filename', true);

        $fileHandlerMock = $this->createMock(FileHandler::class);
        $fileHandlerMock->expects($this->atLeastOnce())->method('isFile')->with($fileName)->willReturn(true);
        $fileHandlerMock->expects($this->atLeastOnce())->method('readContent')->with($fileName)->willReturn($json);

        $loader = new PriceTypeLoader($fileHandlerMock);
        $this->expectException(InvalidArgumentException::class);
        $loader->load($fileName);
    }

    public function invalidDataProvider(): array
    {
        return [
            ['invalidJson'],
            [''],
            ['true'],
            ['[]'],
            ['[{"wrong": "name"}]'],
        ];
    }
}
