<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingFailedMessage;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Core\Log\Context\MessageFQNContext::class)]
class MessageFQNContextTest extends TestCase
{
    #[Test]
    public function it_is_invokable(): void
    {
        $context = new MessageFQNContext(SendOfferListingFailedMessage::class);
        $record = $context([]);
        self::assertArrayHasKey('extra', $record);
        self::assertArrayHasKey('messageFQN', $record['extra']);
        self::assertSame(SendOfferListingFailedMessage::class, $record['extra']['messageFQN']);
    }

    #[Test]
    public function it_can_create_context_instance(): void
    {
        $sut = new MessageFQNContext(SendOfferListingFailedMessage::class);
        self::assertSame($sut, $sut->createContextInstance());
    }


}
