<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/15/21
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderConfirmed;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Event\Seller\OrderConfirmedEvent::class)]
class OrderConfirmedEventTest extends TestCase
{
    #[Test]
    public function it_can_provide_correct_event(): void
    {
        $event = new SellerEventOrderConfirmed();
        $sut = new OrderConfirmedEvent('id', 'version', new DateTimeImmutable(), $event);
        $this->assertSame($event, $sut->getEvent());
    }
}
