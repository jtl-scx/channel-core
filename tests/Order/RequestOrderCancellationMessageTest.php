<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 12/10/20
 */

namespace JTL\SCX\Lib\Channel\Order;

use JTL\SCX\Lib\Channel\Contract\Core\Message\ChannelOrderIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerIdRelatedMessage;
use JTL\SCX\Lib\Channel\Order\Cancellation\Buyer\OrderCancellationItemList;
use JTL\SCX\Lib\Channel\Order\Cancellation\Buyer\RequestCancellationMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Order\Cancellation\Buyer\RequestCancellationMessage
 */
class RequestOrderCancellationMessageTest extends TestCase
{

    /**
     * @test
     */
    public function it_is_sellerId_related_message(): void
    {
        $sut = $this->buildMessage();
        $this->assertInstanceOf(SellerIdRelatedMessage::class, $sut);
    }

    /**
     * @test
     */
    public function it_is_channelOrderId_related_message(): void
    {
        $sut = $this->buildMessage();
        $this->assertInstanceOf(ChannelOrderIdRelatedMessage::class, $sut);
    }

    /**
     * @test
     */
    public function it_has_a_orderCancellationRequestId(): void
    {
        $sut = $this->buildMessage();
        $this->assertEquals('A_ID', $sut->getOrderCancellationRequestId());
    }

    /**
     * @test
     */
    public function it_has_a_sellerId(): void
    {
        $sut = $this->buildMessage();
        $this->assertInstanceOf(ChannelSellerId::class, $sut->getSellerId());
    }

    /**
     * @test
     */
    public function it_has_a_orderId(): void
    {
        $sut = $this->buildMessage();
        $this->assertEquals('A_ORDER_ID', $sut->getChannelOrderId());
    }

    /**
     * @test
     */
    public function it_has_a_OrderItemList(): void
    {
        $sut = $this->buildMessage();
        $this->assertInstanceOf(OrderCancellationItemList::class, $sut->getOrderCancellationItemList());
    }

    /**
     * @test
     */
    public function it_may_has_a_cancelReason(): void
    {
        $reason = 'a_reason';
        $sut = new RequestCancellationMessage(
            'A_ID',
            new ChannelSellerId('A_SELLER_ID'),
            'A_ORDER_ID',
            new OrderCancellationItemList(),
            $reason
        );
        $this->assertEquals($reason, $sut->getCancelReason());
    }

    /**
     * @test
     */
    public function cancelReason_can_be_null(): void
    {
        $sut = $this->buildMessage();
        $this->assertNull($sut->getCancelReason());
    }

    /**
     * @test
     */
    public function it_may_has_a_massage(): void
    {
        $message = 'a_message';
        $sut = new RequestCancellationMessage(
            'A_ID',
            new ChannelSellerId('A_SELLER_ID'),
            'A_ORDER_ID',
            new OrderCancellationItemList(),
            null,
            $message
        );
        $this->assertEquals($message, $sut->getMessage());
    }

    /**
     * @test
     */
    public function message_can_be_null(): void
    {
        $sut = $this->buildMessage();
        $this->assertNull($sut->getMessage());
    }

    private function buildMessage(): RequestCancellationMessage
    {
        return new RequestCancellationMessage(
            'A_ID',
            new ChannelSellerId('A_SELLER_ID'),
            'A_ORDER_ID',
            new OrderCancellationItemList(),
        );
    }
}
