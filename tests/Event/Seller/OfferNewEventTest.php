<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/11/20
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use PHPUnit\Framework\Attributes\CoversClass;
use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferNew;
use PHPUnit\Framework\TestCase;

/**
 * Class OfferUpdateEventTest
 */
#[CoversClass(\JTL\SCX\Lib\Channel\Event\Seller\OfferNewEvent::class)]
class OfferNewEventTest extends TestCase
{
    public function testCanReceiveEvent()
    {
        $apiEventModel = $this->createStub(SellerEventOfferNew::class);
        $event = new OfferNewEvent('id', 'version', new DateTimeImmutable(), $apiEventModel);
        $this->assertSame($apiEventModel, $event->getEvent());
    }
}
