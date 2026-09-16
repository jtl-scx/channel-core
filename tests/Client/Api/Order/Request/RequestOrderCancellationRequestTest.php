<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-12-08
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Request;

use PHPUnit\Framework\Attributes\CoversClass;
use JTL\SCX\Lib\Channel\Client\Model\OrderCancellationRequest;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Order\Request\RequestOrderCancellationRequest::class)]
class RequestOrderCancellationRequestTest extends TestCase
{
    public function testCanBeCreatedAndUsed(): void
    {
        $cancellationRequest = $this->createStub(OrderCancellationRequest::class);

        $request = new RequestOrderCancellationRequest($cancellationRequest);

        $this->assertSame($cancellationRequest, $request->getCancellationRequest());
        $this->assertSame((string)$cancellationRequest, $request->getBody());
        $this->assertSame('POST', $request->getHttpMethod());
        $this->assertSame('/v1/channel/order/cancellation', $request->getUrl());
    }
}
