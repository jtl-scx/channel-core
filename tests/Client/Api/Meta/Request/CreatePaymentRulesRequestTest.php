<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-08-17
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Meta\Request;

use JTL\SCX\Lib\Channel\Client\Model\PaymentRules;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Meta\Request\CreatePaymentRulesRequest
 */
class CreatePaymentRulesRequestTest extends TestCase
{
    public function testCanBeCreatedAndUsed(): void
    {
        $bodyStr = uniqid('body', true);
        $paymentRules = $this->createMock(PaymentRules::class);
        $paymentRules->expects($this->atLeastOnce())->method('__toString')->willReturn($bodyStr);

        $request = new CreatePaymentRulesRequest($paymentRules);
        $this->assertSame($bodyStr, $request->getBody());
        $this->assertSame('PUT', $request->getHttpMethod());
        $this->assertSame('/v1/channel/payment-rules', $request->getUrl());
    }
}
