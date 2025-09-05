<?php

declare(strict_types=1);

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
            clientVersion: uniqid(),
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

    /** @test */
    public function it_uses_default_delay_and_retry_delay_when_not_provided(): void
    {
        $sut = new class (
            id: uniqid(),
            clientVersion: uniqid(),
            createdAt: new \DateTimeImmutable(),
            type: $this->createStub(EventType::class),
        ) extends AbstractEvent {
        };

        self::assertSame(0, $sut->getDelay(), 'Default enqueue delay should be 0');
        self::assertSame(120, $sut->getRetryDelay(), 'Default retry delay should be 120 seconds as defined by AbstractEvent');
    }

    /** @test */
    public function it_delegates_retry_count_to_parent_when_not_set(): void
    {
        $sut = new class (
            id: uniqid(),
            clientVersion: uniqid(),
            createdAt: new \DateTimeImmutable(),
            type: $this->createStub(EventType::class),
            internalEventId: uniqid()
        ) extends AbstractEvent {
        };

        self::assertSame(3, $sut->getRetryCount(), 'Should use parent default retry count when not provided');

        $sut2 = new class (
            id: uniqid(),
            clientVersion: uniqid(),
            createdAt: new \DateTimeImmutable(),
            type: $this->createStub(EventType::class),
            internalEventId: uniqid(),
            retryCount: 7
        ) extends AbstractEvent {
        };
        self::assertSame(7, $sut2->getRetryCount());
    }
}
