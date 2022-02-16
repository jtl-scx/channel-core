<?php

namespace JTL\SCX\Lib\Channel\Event;

use JTL\SCX\Lib\Channel\Client\Event\EventType;
use PHPUnit\Framework\TestCase;

/**
 * @covers  \JTL\SCX\Lib\Channel\Event\AbstractEvent
 */
class AbstractEventTest extends TestCase
{
    public function testCanBeUsed(): void
    {
        $id = uniqid();
        $createdAt = new \DateTimeImmutable();
        $type = $this->createStub(EventType::class);
        $internalEventId = uniqid();

        $sut = new TestEvent($id, $createdAt, $type, $internalEventId);

        self::assertSame($id, $sut->getId());
        self::assertSame($createdAt, $sut->getCreatedAt());
        self::assertSame($type, $sut->getType());
        self::assertSame($internalEventId, $sut->getMessageId());
    }
}

class TestEvent extends AbstractEvent
{
}
