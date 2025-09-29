<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SystemEventNotification;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Event\Seller\SystemNotificationEvent
 */
class SystemNotificationEventTest extends TestCase
{
    public function test_it_can_receive_event(): void
    {
        $apiEventModel = $this->createStub(SystemEventNotification::class);
        $event = new SystemNotificationEvent('id', 'version', new DateTimeImmutable(), $apiEventModel);
        self::assertSame($apiEventModel, $event->getEvent());
    }

    public function test_it_sets_event_type_to_system_notification(): void
    {
        $apiEventModel = $this->createStub(SystemEventNotification::class);
        $event = new SystemNotificationEvent('id', 'version', new DateTimeImmutable(), $apiEventModel);
        self::assertInstanceOf(EventType::class, $event->getType());
        self::assertEquals(EventType::SystemNotification()->getValue(), $event->getType()->getValue());
    }
}
