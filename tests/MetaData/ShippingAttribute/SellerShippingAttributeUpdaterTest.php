<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\MetaData\ShippingAttribute;

use JTL\SCX\Lib\Channel\Client\Api\Meta\Request\PutSellerShippingRulesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Meta\Response\PutSellerShippingRulesResponse;
use JTL\SCX\Lib\Channel\Client\Api\Meta\ShippingRulesApi;
use JTL\SCX\Lib\Channel\Client\Model\ChannelSpecificShippingAttribute;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\MetaData\ShippingAttribute\SellerShippingAttributeUpdater
 */
class SellerShippingAttributeUpdaterTest extends TestCase
{
    public function testCanUpdate(): void
    {
        $sellerId = uniqid('sellerId', true);
        $attributeList = [new ChannelSpecificShippingAttribute(['attributeId' => 'returnAddressCarrierId'])];

        $apiClientMock = $this->createMock(ShippingRulesApi::class);
        $apiClientMock->expects($this->once())
            ->method('putSellerShippingRules')
            ->with($this->isInstanceOf(PutSellerShippingRulesRequest::class))
            ->willReturn(new PutSellerShippingRulesResponse(201));

        $sut = new SellerShippingAttributeUpdater($apiClientMock);
        $sut->update($sellerId, $attributeList);
    }

    public function testThrowsOnUnexpectedStatus(): void
    {
        $sellerId = uniqid('sellerId', true);
        $attributeList = [new ChannelSpecificShippingAttribute(['attributeId' => 'returnAddressCarrierId'])];

        $apiClientMock = $this->createMock(ShippingRulesApi::class);
        $apiClientMock->method('putSellerShippingRules')->willReturn(new PutSellerShippingRulesResponse(400));

        $sut = new SellerShippingAttributeUpdater($apiClientMock);

        $this->expectException(UnexpectedStatusException::class);
        $sut->update($sellerId, $attributeList);
    }
}
