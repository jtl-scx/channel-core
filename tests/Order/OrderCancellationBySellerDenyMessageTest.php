<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-22
 */

namespace Order;

use JTL\SCX\Lib\Channel\Order\Cancellation\Seller\CancellationDenyMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Order\Cancellation\Seller\CancellationDenyMessage
 */
class OrderCancellationBySellerDenyMessageTest extends TestCase
{
    public function testGetReason()
    {
        $reason = uniqid('reason', true);
        $message = new CancellationDenyMessage(
            $this->createStub(ChannelSellerId::class),
            uniqid('orderCancellationRequestId', true),
            uniqid('orderId', true),
            $reason
        );

        self::assertInstanceOf(CancellationDenyMessage::class, $message);
        self::assertSame($reason, $message->getReason());
    }
}
