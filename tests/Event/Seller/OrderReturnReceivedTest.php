<?php

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Client\Channel\Model\SellerEventOrderReturnReceived;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Event\Seller\OrderReturnReceived
 */
class OrderReturnReceivedTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_deliver_a_SellerEventOrderReturnReceived(): void
    {
        $sut = new OrderReturnReceived(
            'A_ID',
            self::createStub(DateTimeImmutable::class),
            $expectedEvent = self::createStub(SellerEventOrderReturnReceived::class)
        );
        self::assertSame($expectedEvent, $sut->getEvent());
    }

    /**
     * @test
     */
    public function it_implement_SellerIdRelatedMessage(): void
    {
        $sut = new OrderReturnReceived(
            'A_ID',
            self::createStub(DateTimeImmutable::class),
            $expectedEvent = self::createStub(SellerEventOrderReturnReceived::class)
        );

        $expectedSellerId = 'A_SELLER_ID';
        $expectedEvent->method('getSellerId')->willReturn($expectedSellerId);
        self::assertSame($expectedSellerId, $sut->getSellerId()->getId());
    }

    /**
     * @test
     */
    public function it_implement_ChannelOrderIdRelatedMessage(): void
    {
        $sut = new OrderReturnReceived(
            'A_ID',
            self::createStub(DateTimeImmutable::class),
            $expectedEvent = self::createStub(SellerEventOrderReturnReceived::class)
        );

        $expectedOrderId = 'A_ORDER_ID';
        $expectedEvent->method('getOrderId')->willReturn($expectedOrderId);
        self::assertSame($expectedOrderId, $sut->getChannelOrderId());
    }
}
