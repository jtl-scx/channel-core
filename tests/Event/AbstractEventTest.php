<?php

namespace JTL\SCX\Lib\Channel\Event;

use JTL\SCX\Lib\Channel\Client\Event\EventType;
use PHPUnit\Framework\TestCase;

/**
 * @covers  \JTL\SCX\Lib\Channel\Event\AbstractEvent
 */
class AbstractEventTest extends TestCase
{
    public function test_it_can_be_constructed_correctly(): void
    {
        $sut = new class (
            id: $id = uniqid(),
            createdAt:  $createdAt = new \DateTimeImmutable(),
            type: $type = $this->createStub(EventType::class),
            internalEventId: $internalEventId = uniqid(),
            delay: $delay = random_int(1, 10000),
            retryDelay: $retryDelay = random_int(1, 10000),
            retryCount: $retryCount = random_int(1, 10000)
        ) extends AbstractEvent {
        };

        self::assertSame($id, $sut->getId());
        self::assertSame($createdAt, $sut->getCreatedAt());
        self::assertSame($type, $sut->getType());
        self::assertSame($internalEventId, $sut->getMessageId());
        self::assertEquals($delay, $sut->getDelay());
        self::assertEquals($retryDelay, $sut->getRetryDelay());
        self::assertEquals($retryCount, $sut->getRetryCount());
    }
}
