<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/23
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Event\Model;

use PHPUnit\Framework\TestCase;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferEnd;

/**
 * Class EventContainerTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Event\Model
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Event\Model\EventContainer
 */
class EventContainerTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $id = uniqid('id', true);
        $createdAt = new \DateTimeImmutable();
        $type = $this->createStub(EventType::class);
        $event = $this->createStub(SellerEventOfferEnd::class);

        $eventContainer = new EventContainer($id, $createdAt, $type, $event);

        $this->assertSame($id, $eventContainer->getId());
        $this->assertSame($createdAt, $eventContainer->getCreatedAt());
        $this->assertSame($type, $eventContainer->getType());
        $this->assertSame($event, $eventContainer->getEvent());
    }
}
