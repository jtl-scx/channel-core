<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/15/21
 */

namespace Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Client\Channel\Model\OrderAccept;
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
        $event = new OrderAccept();
        $sut = new OrderAcceptEvent('id', new DateTimeImmutable(), $event);
        $this->assertSame($event, $sut->getEvent());
    }
}