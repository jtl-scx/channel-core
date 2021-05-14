<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace ChannelApi;

use JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingInProgressMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingInProgressMessage
 */
class SendOfferListingInProgressMessageTest extends TestCase
{
    public function testCanBeUsed(): void
    {
        $sellerId = $this->createStub(ChannelSellerId::class);
        $sellerOfferId = random_int(1, 10000);
        $startedAt = $this->createStub(\DateTime::class);
        $msgId = uniqid('msgId', true);
        $msg = new SendOfferListingInProgressMessage($sellerId, $sellerOfferId, $startedAt, $msgId);

        self::assertSame($sellerId, $msg->getSellerId());
        self::assertSame($sellerOfferId, $msg->getSellerOfferId());
        self::assertSame($startedAt, $msg->getStartedAt());
        self::assertSame($msgId, $msg->getMessageId());
    }
}
