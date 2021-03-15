<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/03/15
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Client\Channel\Api\Attribute\AttributesApi;
use PHPUnit\Framework\TestCase;
use JTL\SCX\Client\Channel\Model\AttributeList as ClientAttributeList;

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
        $clientAttributeList = new ClientAttributeList();

        $mapper->expects($this->once())->method('map')->with($attributeList)->willReturn([]);
        $api->expects($this->once())->method('createGlobalAttributes');

        $sut = new GlobalAttributeSender($mapper, $api);
        $sut->send($attributeList);
    }
}
