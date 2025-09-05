<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferStockUpdate;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Event\Seller\OfferStockUpdateEvent
 */
class OfferStockUpdateEventTest extends TestCase
{
    public function test_it_can_be_created(): void
    {
        $id = uniqid('id', true);
        $version = '1.0.0';
        $createdAt = new DateTimeImmutable();

        $event = $this->createMock(SellerEventOfferStockUpdate::class);

        $offerStockUpdateEvent = new OfferStockUpdateEvent(
            $id,
            $version,
            $createdAt,
            $event
        );

        self::assertSame($id, $offerStockUpdateEvent->getId());
        self::assertSame($version, $offerStockUpdateEvent->getClientVersion());
        self::assertSame($createdAt, $offerStockUpdateEvent->getCreatedAt());
        self::assertSame($event, $offerStockUpdateEvent->getEvent());
    }
}
