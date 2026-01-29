<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Offer\Request;

use PHPUnit\Framework\TestCase;

/**
 * @covers GetAllStockUpdatesRequest
 */
class GetAllStockUpdatesRequestTest extends TestCase
{
    public function testCanBeCreatedAndUsed()
    {
        $dateTime = new \DateTime();
        $request = new GetAllStockUpdatesRequest($dateTime);

        $this->assertSame('GET', $request->getHttpMethod());
        $this->assertSame('/v1/channel/offer/stock-updates/all', $request->getUrl());
        $this->assertSame(['updatedAfter' => $dateTime->format(\DateTimeInterface::ATOM)], $request->getParams());
    }
}
