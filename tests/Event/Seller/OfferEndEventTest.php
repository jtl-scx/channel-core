<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/11/20
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferEnd;
use PHPUnit\Framework\TestCase;

/**
 * Class OfferUpdateEventTest
 * @covers \JTL\SCX\Lib\Channel\Event\Seller\OfferEndEvent
 */
class OfferEndEventTest extends TestCase
{
    public function testCanReceiveEvent()
    {
        $apiEventModel = $this->createStub(SellerEventOfferEnd::class);
        $event = new OfferEndEvent('id', new \DateTimeImmutable(), $apiEventModel);
        $this->assertSame($apiEventModel, $event->getEvent());
    }
}
