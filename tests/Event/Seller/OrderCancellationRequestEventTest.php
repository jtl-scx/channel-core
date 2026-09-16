<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Event\Seller;

use PHPUnit\Framework\Attributes\CoversClass;
use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderCancellationRequest;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Event\Seller\OrderCancellationRequestEvent::class)]
class OrderCancellationRequestEventTest extends TestCase
{
    public function test_it_can_be_created(): void
    {
        $id = uniqid('id', true);
        $version = '1.0.0';
        $createdAt = new DateTimeImmutable();

        $event = $this->createStub(SellerEventOrderCancellationRequest::class);

        $orderCancellationRequestEvent = new OrderCancellationRequestEvent(
            $id,
            $version,
            $createdAt,
            $event
        );

        self::assertSame($id, $orderCancellationRequestEvent->getId());
        self::assertSame($version, $orderCancellationRequestEvent->getClientVersion());
        self::assertSame($createdAt, $orderCancellationRequestEvent->getCreatedAt());
        self::assertSame($event, $orderCancellationRequestEvent->getEvent());
    }
}
