<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderCancellationAccepted;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Event\Seller\OrderCancellationAcceptedEvent
 */
class OrderCancellationAcceptedEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_created(): void
    {
        $id = uniqid('id', true);
        $version = uniqid('version', true);
        $createdAt = new DateTimeImmutable();

        $event = $this->createMock(SellerEventOrderCancellationAccepted::class);

        $sut = new OrderCancellationAcceptedEvent(
            $id,
            $version,
            $createdAt,
            $event
        );

        self::assertSame($id, $sut->getId());
        self::assertSame($version, $sut->getClientVersion());
        self::assertSame($createdAt, $sut->getCreatedAt());
        self::assertSame($event, $sut->getEvent());
    }
}
