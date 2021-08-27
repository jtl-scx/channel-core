<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\ChannelApi;

use JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingSuccessfulMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingSuccessfulMessage
 */
class SendOfferListingSuccessfulMessageTest extends TestCase
{
    public function testCanBeUsed(): void
    {
        $sellerId = $this->createStub(ChannelSellerId::class);
        $sellerOfferId = random_int(1, 10000);
        $channelOfferId = uniqid('channelOfferId', true);
        $listingUrl = uniqid('listingUrl', true);
        $listedAt = $this->createStub(\DateTime::class);
        $msgId = uniqid('msgId', true);
        $msg = new SendOfferListingSuccessfulMessage($sellerId, $sellerOfferId, $channelOfferId, $listingUrl, $listedAt, $msgId);

        self::assertSame($sellerId, $msg->getSellerId());
        self::assertSame($sellerOfferId, $msg->getSellerOfferId());
        self::assertSame($channelOfferId, $msg->getChannelOfferId());
        self::assertSame($listingUrl, $msg->getListingUrl());
        self::assertSame($listedAt, $msg->getListedAt());
        self::assertSame($msgId, $msg->getMessageId());
    }
}
