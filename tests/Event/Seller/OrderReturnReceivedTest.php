<?php

namespace JTL\SCX\Lib\Channel\Event\Seller;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderReturnReceived;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Event\Seller\OrderReturnReceived::class)]
class OrderReturnReceivedTest extends TestCase
{
    #[Test]
    public function it_can_deliver_a_SellerEventOrderReturnReceived(): void
    {
        $sut = new OrderReturnReceived(
            'A_ID',
            'VERSION',
            self::createStub(DateTimeImmutable::class),
            $expectedEvent = self::createStub(SellerEventOrderReturnReceived::class)
        );
        self::assertSame($expectedEvent, $sut->getEvent());
    }

    #[Test]
    public function it_implement_SellerIdRelatedMessage(): void
    {
        $sut = new OrderReturnReceived(
            'A_ID',
            'VERSION',
            self::createStub(DateTimeImmutable::class),
            $expectedEvent = self::createStub(SellerEventOrderReturnReceived::class)
        );

        $expectedSellerId = 'A_SELLER_ID';
        $expectedEvent->method('getSellerId')->willReturn($expectedSellerId);
        self::assertSame($expectedSellerId, $sut->getSellerId()->getId());
    }

    #[Test]
    public function it_implement_ChannelOrderIdRelatedMessage(): void
    {
        $sut = new OrderReturnReceived(
            'A_ID',
            'VERSION',
            self::createStub(DateTimeImmutable::class),
            $expectedEvent = self::createStub(SellerEventOrderReturnReceived::class)
        );

        $expectedOrderId = 'A_ORDER_ID';
        $expectedEvent->method('getOrderId')->willReturn($expectedOrderId);
        self::assertSame($expectedOrderId, $sut->getChannelOrderId());
    }
}
