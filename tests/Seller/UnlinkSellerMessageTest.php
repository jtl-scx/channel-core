<?php

namespace JTL\SCX\Lib\Channel\Seller;

use PHPUnit\Framework\TestCase;

/**
 * @covers  \JTL\SCX\Lib\Channel\Seller\UnlinkSellerMessage
 */
class UnlinkSellerMessageTest extends TestCase
{
    public function testCanGetReason(): void
    {
        $reason = uniqid('reason', true);
        $sut = new UnlinkSellerMessage($this->createStub(ChannelSellerId::class), $reason);

        self::assertSame($reason, $sut->getReason());
    }

    public function testCanGetSellerId(): void
    {
        $channelSellerId = $this->createStub(ChannelSellerId::class);
        $sut = new UnlinkSellerMessage($channelSellerId, uniqid('reason', true));

        self::assertSame($channelSellerId, $sut->getSellerId());
    }
}
