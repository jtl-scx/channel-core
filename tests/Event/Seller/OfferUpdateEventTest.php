<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/11/20
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use JTL\SCX\Client\Channel\Model\SellerEventOfferUpdate;
use PHPUnit\Framework\TestCase;

/**
 * Class OfferUpdateEventTest
 * @covers \JTL\SCX\Lib\Channel\Event\Seller\OfferUpdateEvent
 */
class OfferUpdateEventTest extends TestCase
{
    public function testCanReceiveEvent()
    {
        $apiEventModel = $this->createStub(SellerEventOfferUpdate::class);
        $event = new OfferUpdateEvent('id', new \DateTimeImmutable(), $apiEventModel);
        $this->assertSame($apiEventModel, $event->getEvent());
    }
}
