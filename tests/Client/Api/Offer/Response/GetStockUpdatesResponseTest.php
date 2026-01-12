<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Offer\Response;

use JTL\SCX\Lib\Channel\Client\Model\StockList;
use PHPUnit\Framework\TestCase;

/**
 * @covers GetStockUpdatesResponse
 */
class GetStockUpdatesResponseTest extends TestCase
{
    public function testCanGetData(): void
    {
        $stockList = $this->createStub(StockList::class);
        $statusCode = random_int(1, 1000);

        $response = new GetStockUpdatesResponse($stockList, $statusCode);

        $this->assertEquals($stockList, $response->getStockList());
        $this->assertEquals($statusCode, $response->getStatusCode());
    }
}
