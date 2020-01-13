<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-02
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;


use JTL\SCX\Client\Channel\Api\Attribute\AttributesApi;
use JTL\SCX\Client\Channel\Api\Attribute\Request\CreateSellerAttributesRequest;
use JTL\SCX\Client\Channel\Api\Attribute\Response\AttributesCreatedResponse;
use PHPUnit\Framework\TestCase;

/**
 * Class SellerAttributeUpdaterTest
 * @package JTL\SCX\Lib\Channel\MetaData\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\SellerAttributeUpdater
 */
class SellerAttributeUpdaterTest extends TestCase
{
    public function testCanUpdate():void
    {
        $sellerId = uniqid('sellerId', true);

        $attrListMock = $this->createMock(AttributeList::class);
        $clientAttrList = [];

        $createSellerResponse= $this->createMock(AttributesCreatedResponse::class);
        $createSellerResponse->method('getStatusCode')->willReturn(201);
        $apiClientMock = $this->createMock(AttributesApi::class);
        $apiClientMock->expects($this->once())
            ->method('createSellerAttributes')
            ->with($this->isInstanceOf(CreateSellerAttributesRequest::class))
            ->willReturn($createSellerResponse);

        $attrMapperMock = $this->createMock(AttributeMapper::class);
        $attrMapperMock->expects($this->atLeastOnce())->method('map')->with($attrListMock)->willReturn($clientAttrList);

        $updater = new SellerAttributeUpdater($apiClientMock, $attrMapperMock);
        $updater->update($sellerId, $attrListMock);
    }
}
