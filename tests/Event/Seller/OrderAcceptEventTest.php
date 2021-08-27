<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/15/21
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Client\Channel\Model\OrderAccept;
use JTL\SCX\Client\Channel\Model\SellerEventOrderAccept;
use JTL\SCX\Lib\Channel\Event\Seller\OrderAcceptEvent;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Event\Seller\OrderAcceptEvent
 */
class OrderAcceptEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_provide_correct_event(): void
    {
        $event = new SellerEventOrderAccept();
        $sut = new OrderAcceptEvent('id', new DateTimeImmutable(), $event);
        $this->assertSame($event, $sut->getEvent());
    }
}
