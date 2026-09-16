<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Offer\Request;

use DateTime;
use DateTimeInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(GetStockUpdatesBySellerRequest::class)]
class GetStockUpdatesBySellerRequestTest extends TestCase
{
    public function testCanBeCreatedAndUsed()
    {
        $dateTime = new DateTime();
        $sellerId = uniqid('sellerId', true);
        $request = new GetStockUpdatesBySellerRequest($dateTime, $sellerId);

        $this->assertSame('GET', $request->getHttpMethod());
        $this->assertSame('/v1/channel/offer/stock-updates', $request->getUrl());
        $this->assertSame(
            [
                'updatedAfter' => $dateTime->format(DateTimeInterface::ATOM),
                'sellerId' => $sellerId
            ],
            $request->getParams()
        );
    }
}
