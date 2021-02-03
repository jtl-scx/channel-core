<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-22
 */

namespace Order;

use JTL\SCX\Lib\Channel\Order\Cancellation\Seller\CancellationAcceptMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Order\Cancellation\Seller\CancellationAcceptMessage
 */
class CancellationAcceptMessageTest extends TestCase
{
    private CancellationAcceptMessage $message;
    private $channelSellerId;
    private string $orderCancellationRequestId;
    private string $orderId;

    public function setUp(): void
    {
        $this->channelSellerId = $this->createStub(ChannelSellerId::class);
        $this->orderCancellationRequestId = uniqid('orderCancellationRequestId', true);
        $this->orderId = uniqid('orderId', true);
        $this->message = new CancellationAcceptMessage(
            $this->channelSellerId,
            $this->orderCancellationRequestId,
            $this->orderId
        );
    }

    public function testCanGetSellerId(): void
    {
        self::assertSame($this->channelSellerId, $this->message->getSellerId());
    }

    public function testCanGetChannelOrderId(): void
    {
        self::assertSame($this->orderId, $this->message->getChannelOrderId());
    }

    public function testCanGetCancellationRequestId(): void
    {
        self::assertSame($this->orderCancellationRequestId, $this->message->getCancellationRequestId());
    }
}
