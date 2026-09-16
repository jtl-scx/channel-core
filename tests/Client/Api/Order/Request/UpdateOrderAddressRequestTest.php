<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-03-03
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Request;

use PHPUnit\Framework\Attributes\CoversClass;
use JTL\SCX\Lib\Channel\Client\Model\OrderAddressUpdateList;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateOrderAddressRequestTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Order\Request
 */
#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Order\Request\UpdateOrderAddressRequest::class)]
class UpdateOrderAddressRequestTest extends TestCase
{
    public function testCanBeCreatedAndUsed(): void
    {
        $orderAdressList = $this->createStub(OrderAddressUpdateList::class);

        $request = new UpdateOrderAddressRequest($orderAdressList);

        $this->assertSame($orderAdressList, $request->getOrderAddressList());
        $this->assertSame((string)$orderAdressList, $request->getBody());
        $this->assertSame('PUT', $request->getHttpMethod());
        $this->assertSame('/v1/channel/order/address-update', $request->getUrl());
    }
}
