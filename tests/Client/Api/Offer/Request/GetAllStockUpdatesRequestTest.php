<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Offer\Request;

use DateTime;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(GetAllStockUpdatesRequest::class)]
class GetAllStockUpdatesRequestTest extends TestCase
{
    public function testCanBeCreatedAndUsed(): void
    {
        $dateTime = new DateTime();
        $request = new GetAllStockUpdatesRequest($dateTime);

        $this->assertSame('GET', $request->getHttpMethod());
        $this->assertSame('/v1/channel/offer/stock-updates/all{?updatedAfter}', $request->getUrl());
        $this->assertSame(['updatedAfter' => $dateTime->format('Y-m-d\TH:i:s')], $request->getParams());
    }
}
