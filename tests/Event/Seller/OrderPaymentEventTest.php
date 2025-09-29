<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderPayment;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Event\Seller\OrderPaymentEvent
 */
class OrderPaymentEventTest extends TestCase
{
    public function test_it_can_be_created(): void
    {
        $id = uniqid('id', true);
        $version = '1.0.0';
        $createdAt = new DateTimeImmutable();

        $event = $this->createMock(SellerEventOrderPayment::class);

        $orderPaymentEvent = new OrderPaymentEvent(
            $id,
            $version,
            $createdAt,
            $event
        );

        self::assertSame($id, $orderPaymentEvent->getId());
        self::assertSame($version, $orderPaymentEvent->getClientVersion());
        self::assertSame($createdAt, $orderPaymentEvent->getCreatedAt());
        self::assertSame($event, $orderPaymentEvent->getEvent());
    }
}
