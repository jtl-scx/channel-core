<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/03/15
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Lib\Channel\Client\Api\Attribute\AttributesApi;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\CreateGlobalAttributesRequest;
use PHPUnit\Framework\TestCase;
use JTL\SCX\Lib\Channel\Client\Model\Attribute as ScxAttribute;

/**
 * Class GlobalAttributeSenderTest
 * @package JTL\SCX\Lib\Channel\MetaData\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\GlobalAttributeSender
 */
class GlobalAttributeSenderTest extends TestCase
{
    public function testCanSendAttributes(): void
    {
        $mapper = $this->createMock(AttributeMapper::class);
        $api = $this->createMock(AttributesApi::class);

        $attributeList = new AttributeList();

        $mapper->expects($this->once())->method('map')->with($attributeList)->willReturn([]);
        $api->expects($this->once())->method('createGlobalAttributes');

        $sut = new GlobalAttributeSender($mapper, $api);
        $sut->send($attributeList);
    }

    public function testSendsSmallListInASingleRequest(): void
    {
        $mapper = $this->createMock(AttributeMapper::class);
        $api = $this->createMock(AttributesApi::class);

        $attributeList = $this->createAttributeList(3);

        $mapper->expects($this->once())->method('map')->willReturn([]);
        $api->expects($this->once())->method('createGlobalAttributes');

        $sut = new GlobalAttributeSender($mapper, $api, 10);
        $sut->send($attributeList);
    }

    public function testSplitsListExceedingChunkSizeIntoMultipleRequests(): void
    {
        $mapper = $this->createMock(AttributeMapper::class);
        $api = $this->createMock(AttributesApi::class);

        $attributeList = $this->createAttributeList(7);

        $chunkSizes = [];
        $mapper->expects($this->exactly(3))
            ->method('map')
            ->willReturnCallback(function (AttributeList $chunk) use (&$chunkSizes): array {
                $chunkSizes[] = $chunk->count();
                return [];
            });
        $api->expects($this->exactly(3))->method('createGlobalAttributes');

        $sut = new GlobalAttributeSender($mapper, $api, 3);
        $sut->send($attributeList);

        self::assertSame([3, 3, 1], $chunkSizes);
    }

    public function testEveryChunkKeepsItsOwnAttributesInOrder(): void
    {
        $mapper = $this->createMock(AttributeMapper::class);
        $api = $this->createMock(AttributesApi::class);

        $attributeList = $this->createAttributeList(4);

        $sentAttributeIds = [];
        $mapper->method('map')->willReturnCallback(
            function (AttributeList $chunk) use (&$sentAttributeIds): array {
                $ids = [];
                /** @var Attribute $attribute */
                foreach ($chunk as $attribute) {
                    $ids[] = $attribute->getAttributeId();
                }
                $sentAttributeIds[] = $ids;
                return [];
            }
        );

        $sut = new GlobalAttributeSender($mapper, $api, 2);
        $sut->send($attributeList);

        self::assertSame([['attr-0', 'attr-1'], ['attr-2', 'attr-3']], $sentAttributeIds);
    }

    public function testPassesMappedAttributesIntoTheRequestBody(): void
    {
        $mapper = $this->createMock(AttributeMapper::class);
        $api = $this->createMock(AttributesApi::class);

        $mappedAttribute = new ScxAttribute(['attributeId' => 'attr-0', 'displayName' => 'Attribute 0']);
        $mapper->method('map')->willReturn([$mappedAttribute]);

        $api->expects($this->once())
            ->method('createGlobalAttributes')
            ->with($this->callback(
                static function (CreateGlobalAttributesRequest $request) use ($mappedAttribute): bool {
                    return str_contains((string)$request->getBody(), 'attr-0');
                }
            ));

        $sut = new GlobalAttributeSender($mapper, $api, 10);
        $sut->send($this->createAttributeList(1));
    }

    public function testStillSendsExactlyOneRequestForAnEmptyList(): void
    {
        $mapper = $this->createMock(AttributeMapper::class);
        $api = $this->createMock(AttributesApi::class);

        $emptyList = new AttributeList();

        $mapper->expects($this->once())->method('map')->with($emptyList)->willReturn([]);
        $api->expects($this->once())->method('createGlobalAttributes');

        $sut = new GlobalAttributeSender($mapper, $api, 10);
        $sut->send($emptyList);
    }

    private function createAttributeList(int $amount): AttributeList
    {
        $attributeList = new AttributeList();
        for ($i = 0; $i < $amount; $i++) {
            $attributeList->add(new Attribute("attr-{$i}", "Attribute {$i}"));
        }

        return $attributeList;
    }
}
