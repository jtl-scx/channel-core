<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\ChannelApi;

use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingFailedMessage
 */
class SendOfferListingFailedMessageTest extends TestCase
{
    /**
     * @test
     * @ticket EA-6714
     */
    public function it_create_a_multibyte_save_error_message(): void
    {
        $tooLong = <<<TXT
Auf der Grundlage der Daten aus '[shirt_size#?.size_system, age_range_description.value, shirt_size#?.size_class]' ist das Feld '"height_type"' für das Attribut 'shirt_size' nicht zulässig. Erwartet wird höchstens '0' des Feldes '"height_type"' für das Attribut 'shirt_size'.Betroffene Attribute shirt_size
Auf der Grundlage der Daten aus '[shirt_size#?.size_system, age_range_description.value, shirt_size#?.size_class]' ist das Feld '"height_type"' für das Attribut 'shirt_size' nicht zulässig. Erwartet wird höchstens '0' des Feldes '"height_type"' für das Attribut 'shirt_size'.
TXT;

        $sut = new SendOfferListingFailedMessage(
            sellerId: new ChannelSellerId("Foo der Bar"),
            sellerOfferId: 123,
            errorCode: "ICHMAGZUEGE",
            errorMessage: $tooLong
        );

        $sut->addError("ICHMAGZUEGE", $tooLong);

        $jsonEncodable = $sut->getErrorList()[0]->getMessage();
        self::assertJson(json_encode($jsonEncodable));

        $jsonEncodable = $sut->getErrorList()[1]->getMessage();
        self::assertJson(json_encode($jsonEncodable));
    }




    public function testCanBeUsed(): void
    {
        $sellerId = $this->createStub(ChannelSellerId::class);
        $sellerOfferId = random_int(1, 10000);
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
        $sellerOfferId = random_int(1, 10000);
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

    /**
     * @test
     */
    public function it_use_longMessage_when_errorMessage_exceed_maximum_length_on_construct(): void
    {
        $sut = new SendOfferListingFailedMessage(
            $this->createStub(ChannelSellerId::class),
            123,
            'ERR_111',
            str_repeat('A', 251),
        );

        $err = $sut->getErrorList();

        self::assertArrayHasKey(0, $err);
        self::assertEquals(250, strlen($err[0]->getMessage()));
        self::assertEquals(251, strlen($err[0]->getLongMessage()));
    }

    /**
     * @test
     */
    public function it_use_longMessage_when_errorMessage_exceed_maximum_length_on_add_error(): void
    {
        $errorMessage = str_repeat('A', 251);
        $longErrorMessage = str_repeat('B', 251);
        $sut = new SendOfferListingFailedMessage(
            $this->createStub(ChannelSellerId::class),
            123,
            'ERR_111',
            'smallError',
        );
        $sut->addError('ERR_222', $errorMessage, $longErrorMessage);

        $err = $sut->getErrorList();

        self::assertArrayHasKey(1, $err);
        self::assertEquals(250, strlen($err[1]->getMessage()));
        self::assertStringContainsString($longErrorMessage, $err[1]->getLongMessage());
        self::assertStringContainsString($errorMessage, $err[1]->getLongMessage());
    }
}
