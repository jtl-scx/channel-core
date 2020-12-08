<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace ChannelApi;

use JTL\SCX\Client\Channel\Model\ErrorResponseList;
use JTL\SCX\Lib\Channel\ChannelApi\ListingFailedErrorList;
use JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingFailedMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingFailedMessage
 */
class SendOfferListingFailedMessageTest extends TestCase
{
    public function testCanBeUsed(): void
    {
        $sellerId = $this->createStub(ChannelSellerId::class);
        $sellerOfferId = uniqid('sellerOfferId', true);
        $errorCode = uniqid('errorCode', true);
        $errorMsg = uniqid('errorMsg', true);
        $failedAt = $this->createStub(\DateTime::class);
        $msgId = uniqid('msgId', true);
        $msg = new SendOfferListingFailedMessage($sellerId, $sellerOfferId, $errorCode, $errorMsg, $failedAt, $msgId);

        self::assertSame($sellerId, $msg->getSellerId());
        self::assertSame($sellerOfferId, $msg->getSellerOfferId());
        self::assertSame($failedAt, $msg->getFailedAt());
        self::assertSame($msgId, $msg->getMessageId());
        self::assertInstanceOf(ListingFailedErrorList::class, $msg->getErrorList());
        self::assertSame($errorCode, $msg->getErrorList()->offsetGet(0)->getCode());
        self::assertSame($errorMsg, $msg->getErrorList()->offsetGet(0)->getMessage());
    }

    public function testCanAddError(): void
    {
        $sellerId = $this->createStub(ChannelSellerId::class);
        $sellerOfferId = uniqid('sellerOfferId', true);
        $errorCode = uniqid('errorCode', true);
        $errorMsg = uniqid('errorMsg', true);
        $failedAt = $this->createStub(\DateTime::class);
        $msgId = uniqid('msgId', true);
        $msg = new SendOfferListingFailedMessage($sellerId, $sellerOfferId, $errorCode, $errorMsg, $failedAt, $msgId);

        self::assertSame(1, $msg->getErrorList()->count());


        $errorCode2 = uniqid('errorCode2', true);
        $errorMsg2 = uniqid('errorMsg2', true);
        $errorLongMsg2 = uniqid('errorMsg2', true);
        $msg->addError($errorCode2, $errorMsg2, $errorLongMsg2);
        self::assertSame(2, $msg->getErrorList()->count());
        self::assertSame($errorCode2, $msg->getErrorList()->offsetGet(1)->getCode());
        self::assertSame($errorMsg2, $msg->getErrorList()->offsetGet(1)->getMessage());
        self::assertSame($errorLongMsg2, $msg->getErrorList()->offsetGet(1)->getLongMessage());
    }
}
