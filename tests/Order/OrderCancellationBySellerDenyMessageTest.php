<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-22
 */

namespace Order;

use JTL\SCX\Lib\Channel\Order\OrderCancellationBySellerAcceptMessage;
use JTL\SCX\Lib\Channel\Order\OrderCancellationBySellerDenyMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Order\OrderCancellationBySellerDenyMessage
 */
class OrderCancellationBySellerDenyMessageTest extends TestCase
{
    public function testGetReason()
    {
        $reason = uniqid('reason', true);
        $message = new OrderCancellationBySellerDenyMessage(
            $this->createStub(ChannelSellerId::class),
            uniqid('orderCancellationRequestId', true),
            uniqid('orderId', true),
            $reason
        );

        self::assertInstanceOf(OrderCancellationBySellerAcceptMessage::class, $message);
        self::assertSame($reason, $message->getReason());
    }
}
