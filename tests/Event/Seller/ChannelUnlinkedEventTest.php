<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventChannelUnlinked;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Event\Seller\ChannelUnlinkedEvent
 */
class ChannelUnlinkedEventTest extends TestCase
{
    public function test_it_can_be_created(): void
    {
        $id = uniqid('id', true);
        $version = '1.0.0';
        $createdAt = new DateTimeImmutable();

        $event = $this->createMock(SellerEventChannelUnlinked::class);

        $channelUnlinkedEvent = new ChannelUnlinkedEvent(
            $id,
            $version,
            $createdAt,
            $event
        );

        self::assertSame($id, $channelUnlinkedEvent->getId());
        self::assertSame($version, $channelUnlinkedEvent->getClientVersion());
        self::assertSame($createdAt, $channelUnlinkedEvent->getCreatedAt());
        self::assertSame($event, $channelUnlinkedEvent->getEvent());
    }
}
