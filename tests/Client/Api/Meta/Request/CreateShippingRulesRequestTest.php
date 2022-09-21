<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-08-17
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Meta\Request;

use JTL\SCX\Lib\Channel\Client\Model\ShippingRules;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Meta\Request\CreateShippingRulesRequest
 */
class CreateShippingRulesRequestTest extends TestCase
{
    public function testCanBeCreatedAndUsed(): void
    {
        $bodyStr =uniqid('body', true);
        $shippingRules = $this->createMock(ShippingRules::class);
        $shippingRules->expects($this->atLeastOnce())->method('__toString')->willReturn($bodyStr);

        $request = new CreateShippingRulesRequest($shippingRules);
        $this->assertSame($bodyStr, $request->getBody());
        $this->assertSame('PUT', $request->getHttpMethod());
        $this->assertSame('/v1/channel/shipping-rules', $request->getUrl());
    }
}
