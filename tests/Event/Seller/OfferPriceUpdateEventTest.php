<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferPriceUpdate;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Event\Seller\OfferPriceUpdateEvent
 */
class OfferPriceUpdateEventTest extends TestCase
{
    public function test_can_receive_event_and_type()
    {
        $apiEventModel = $this->createStub(SellerEventOfferPriceUpdate::class);
        $event = new OfferPriceUpdateEvent('id', 'version', new DateTimeImmutable(), $apiEventModel);

        $this->assertSame($apiEventModel, $event->getEvent());
        $this->assertEquals(EventType::SellerOfferPriceUpdate(), $event->getType());
    }
}
