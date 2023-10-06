<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Event\Seller;

use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderShipping;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Event\Seller\OrderShippingEvent
 */
class OrderShippingEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_constructed_correctly(): void
    {
        $sut = new OrderShippingEvent(
            id: $id = uniqid(),
            createdAt: $createdAt = new \DateTimeImmutable(),
            event: $event = $this->createStub(SellerEventOrderShipping::class),
            internalEventId: $internalEventId = uniqid(),
            delay: $delay = random_int(1, 10000),
            retryDelay: $retryDelay = random_int(1, 10000),
            retryCount: $retryCount = random_int(1, 10000)
        );

        self::assertSame($id, $sut->getId());
        self::assertSame($createdAt, $sut->getCreatedAt());
        self::assertSame($event, $sut->getEvent());
        self::assertSame($internalEventId, $sut->getMessageId());
        self::assertEquals($delay, $sut->getDelay());
        self::assertEquals($retryDelay, $sut->getRetryDelay());
        self::assertEquals($retryCount, $sut->getRetryCount());

        self::assertEquals(EventType::SellerOrderShipping(), $sut->getType());
    }


}
