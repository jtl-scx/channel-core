<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Meta\Request;

use JTL\SCX\Lib\Channel\Client\Model\SellerShippingRules;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Meta\Request\PutSellerShippingRulesRequest
 */
class PutSellerShippingRulesRequestTest extends TestCase
{
    public function testCanBeCreatedAndUsed(): void
    {
        $sellerId = uniqid('sellerId', true);
        $bodyStr = uniqid('body', true);

        $sellerShippingRules = $this->createMock(SellerShippingRules::class);
        $sellerShippingRules->expects($this->atLeastOnce())->method('__toString')->willReturn($bodyStr);

        $request = new PutSellerShippingRulesRequest($sellerId, $sellerShippingRules);

        $this->assertSame($sellerId, $request->getSellerId());
        $this->assertSame($sellerShippingRules, $request->getSellerShippingRules());
        $this->assertSame($bodyStr, $request->getBody());
        $this->assertSame('PUT', $request->getHttpMethod());
        $this->assertSame('/v1/channel/shipping-rules/{sellerId}', $request->getUrl());
        $this->assertSame(['sellerId' => $sellerId], $request->getParams());
    }
}
