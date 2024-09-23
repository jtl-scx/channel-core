<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use JTL\Nachricht\Contract\Message\Message;
use JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingFailedMessage;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Log\Context\MessageFQNContext
 */
class MessageFQNContextTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_invokable(): void
    {
        $context = new MessageFQNContext(SendOfferListingFailedMessage::class);
        $record = $context([]);
        self::assertArrayHasKey('extra', $record);
        self::assertArrayHasKey('messageFQN', $record['extra']);
        self::assertSame(SendOfferListingFailedMessage::class, $record['extra']['messageFQN']);
    }

    /**
     * @test
     */
    public function it_can_create_context_instance(): void
    {
        $sut = new MessageFQNContext(SendOfferListingFailedMessage::class);
        self::assertSame($this, $sut->createContextInstance());
    }


}
