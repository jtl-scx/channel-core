<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Event\Seller;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderCancellationDenied;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Event\Seller\OrderCancellationDeniedEvent::class)]
class OrderCancellationDeniedEventTest extends TestCase
{
    #[Test]
    public function it_can_be_created(): void
    {
        $id = uniqid('id', true);
        $version = uniqid('version', true);
        $createdAt = new DateTimeImmutable();

        $event = $this->createStub(SellerEventOrderCancellationDenied::class);

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
