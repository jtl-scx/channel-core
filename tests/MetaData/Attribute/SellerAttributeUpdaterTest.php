<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-02
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;


use JTL\SCX\Client\Channel\Api\Attribute\CreateSellerAttributesApi;
use JTL\SCX\Client\Channel\Api\Attribute\Request\CreateSellerAttributesRequest;
use JTL\SCX\Client\Channel\Api\Attribute\Response\CreateSellerAttributesResponse;
use JTL\SCX\Client\Channel\Model\AttributeList as ClientAttributeList;
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

        $numAttr = random_int(5, 100);
        $attrListMock = $this->createMock(AttributeList::class);
        $attrListMock->method('count')->willReturn($numAttr);
        $clientAttrList = [];

        $createSellerResponse= $this->createMock(CreateSellerAttributesResponse::class);
        $createSellerResponse->method('getStatusCode')->willReturn(201);
        $apiClientMock = $this->createMock(CreateSellerAttributesApi::class);
        $apiClientMock->expects($this->once())->method('createSellerAttributes')->with($this->callback(
            function ($request) use ($clientAttrList) {
                if ($request instanceof CreateSellerAttributesRequest && $request->getAttributeList() instanceof ClientAttributeList) {
                    if ($request->getAttributeList()->getAttributeList() === $clientAttrList) {
                        return true;
                    }
                }
                return false;
            }
        ))->willReturn($createSellerResponse);

        $attrMapperMock = $this->createMock(AttributeMapper::class);
        $attrMapperMock->expects($this->atLeastOnce())->method('map')->with($attrListMock)->willReturn($clientAttrList);

        $updater = new SellerAttributeUpdater($apiClientMock, $attrMapperMock);
        $updater->update($sellerId, $attrListMock);
    }
}
