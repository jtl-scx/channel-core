<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/23
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Request;

use PHPUnit\Framework\TestCase;
use JTL\SCX\Lib\Channel\Client\Model\OrderList;

/**
 * Class CreateOrdersRequestTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Order\Request
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Order\Request\CreateOrderRequest
 */
class CreateOrdersRequestTest extends TestCase
{
    public function testCanBeCreatedAndUsed(): void
    {
        $orderList = $this->createMock(OrderList::class);

        $request = new CreateOrderRequest($orderList);

        $this->assertSame($orderList, $request->getOrderList());
        $this->assertSame((string)$orderList, $request->getBody());
        $this->assertSame('POST', $request->getHttpMethod());
        $this->assertSame('/v1/channel/order', $request->getUrl());
    }
}
