<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderCancellationDenied;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Event\Seller\OrderCancellationDeniedEvent
 */
class OrderCancellationDeniedEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_created(): void
    {
        $id = uniqid('id', true);
        $version = uniqid('version', true);
        $createdAt = new DateTimeImmutable();

        $event = $this->createMock(SellerEventOrderCancellationDenied::class);

        $sut = new OrderCancellationDeniedEvent(
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
