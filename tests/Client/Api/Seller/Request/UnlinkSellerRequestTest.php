<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Request;

use JTL\SCX\Lib\Channel\Client\Model\CreateSeller;
use PHPUnit\Framework\TestCase;

/**
 * Class UnlinkSellerRequestTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Seller\Request
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Seller\Request\UnlinkSellerRequest
 */
class UnlinkSellerRequestTest extends TestCase
{
    public function testCanBeCreatedAndValidated(): void
    {
        $sellerId = uniqid('sellerId', true);

        $request = new UnlinkSellerRequest($sellerId);
        $this->assertSame('/v1/channel/seller/{sellerId}{?reason}', $request->getUrl());
        $this->assertSame('DELETE', $request->getHttpMethod());
        $this->assertSame(['sellerId' => $sellerId, 'reason' => null], $request->getParams());
    }

    public function testCanBeCreatedAndValidatedWithReason(): void
    {
        $sellerId = uniqid('sellerId', true);
        $reason = uniqid('reason', true);

        $request = new UnlinkSellerRequest($sellerId, $reason);
        $this->assertSame('/v1/channel/seller/{sellerId}{?reason}', $request->getUrl());
        $this->assertSame('DELETE', $request->getHttpMethod());
        $this->assertSame(['sellerId' => $sellerId, 'reason' => $reason], $request->getParams());
    }
}
