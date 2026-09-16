<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/7/21
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use PHPUnit\Framework\Attributes\CoversClass;
use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderInvoice;
use JTL\SCX\Lib\Channel\Event\Seller\OrderInvoiceEvent;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Event\Seller\OrderInvoiceEvent::class)]
class OrderInvoiceEventTest extends TestCase
{
    public function testCanReceiveEvent()
    {
        $apiEventModel = $this->createStub(SellerEventOrderInvoice::class);
        $event = new OrderInvoiceEvent('id', 'version', new DateTimeImmutable(), $apiEventModel);
        $this->assertSame($apiEventModel, $event->getEvent());
    }
}
