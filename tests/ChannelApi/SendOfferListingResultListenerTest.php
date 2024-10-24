<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\ChannelApi;

use DateTime;
use JTL\SCX\Lib\Channel\Client\Api\Offer\OfferApi;
use JTL\SCX\Lib\Channel\Client\Api\Offer\Request\MarkListingAsFailedRequest;
use JTL\SCX\Lib\Channel\Client\Api\Offer\Request\MarkListingSuccessfulRequest;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingResultListener
 */
class SendOfferListingResultListenerTest extends TestCase
{
    public function testCanSendInFailed(): void
    {
        $sellerIdStr = uniqid('sellerId');
        $sellerId = new ChannelSellerId($sellerIdStr);
        $sellerOfferId = random_int(1, 9999);
        $errorCode = uniqid('errorCode', true);
        $errorMsg = uniqid('errorMsg', true);
        $failedAt = $this->createStub(DateTime::class);
        $event = new SendOfferListingFailedMessage(
            sellerId: $sellerId,
            sellerOfferId: $sellerOfferId,
            errorCode: $errorCode,
            errorMessage: $errorMsg,
            failedAt: $failedAt,
            relatedAttributeId: 'any related Attribute',
            recommendedValue: 'some recommended value'
        );

        $offerApi = $this->createMock(OfferApi::class);
        $offerApi->expects(self::once())->method('markListingFailed')->with(self::callback(
            function (MarkListingAsFailedRequest $request) use (
                $sellerIdStr,
                $sellerOfferId,
                $failedAt,
                $errorCode,
                $errorMsg
            ) {
                $json = $request->getBody();
                self::assertEquals(
                    [
                        'offerList' => [
                            [
                                'sellerId' => $sellerIdStr,
                                'offerId' => (int)$sellerOfferId,
                                'failedAt' => $failedAt->format('c'),
                                'errorList' => [
                                    [
                                        'code' => $errorCode,
                                        'message' => $errorMsg,
                                        'relatedAttributeId' => 'any related Attribute',
                                        'recommendedValue' => 'some recommended value'
                                    ],
                                ],
                            ],
                        ],
                    ],
                    json_decode($json, true)
                );
                return true;
            }
        ));
        $listener = new SendOfferListingResultListener($offerApi, $this->createStub(ScxLogger::class));
        $listener->sendInFailed($event);
    }

    /**
     * @test
     */
    public function it_will_trim_relatedAttributId_to_512_characters_maximum(): void
    {
        $relatedAttributeId = str_repeat('A', 513);
        $event = new SendOfferListingFailedMessage(
            sellerId: new ChannelSellerId('123'),
            sellerOfferId: 1,
            errorCode: 'ABC',
            errorMessage: 'joar geht halt nicht',
            failedAt: new DateTime(),
            relatedAttributeId: $relatedAttributeId,
        );

        $offerApi = $this->createMock(OfferApi::class);
        $offerApi->expects(self::once())->method('markListingFailed')->with(self::callback(
            function (MarkListingAsFailedRequest $request) use ($relatedAttributeId) {
                $json = $request->getBody();
                self::assertEquals(
                    mb_substr($relatedAttributeId, 0, 512),
                    json_decode($json, true)['offerList'][0]['errorList'][0]['relatedAttributeId']
                );
                return true;
            }
        ));
        $listener = new SendOfferListingResultListener($offerApi, $this->createStub(ScxLogger::class));
        $listener->sendInFailed($event);
    }

    /**
     * @test
     */
    public function it_will_trim_recommendedValue_to_1000_characters_maximum(): void
    {
        $recommendedValue = str_repeat('A', 1001);
        $event = new SendOfferListingFailedMessage(
            sellerId: new ChannelSellerId('123'),
            sellerOfferId: 1,
            errorCode: 'ABC',
            errorMessage: 'joar geht halt nicht',
            failedAt: new DateTime(),
            recommendedValue: $recommendedValue,
        );

        $offerApi = $this->createMock(OfferApi::class);
        $offerApi->expects(self::once())->method('markListingFailed')->with(self::callback(
            function (MarkListingAsFailedRequest $request) use ($recommendedValue) {
                $json = $request->getBody();
                self::assertEquals(
                    mb_substr($recommendedValue, 0, 1000),
                    json_decode($json, true)['offerList'][0]['errorList'][0]['recommendedValue']
                );
                return true;
            }
        ));
        $listener = new SendOfferListingResultListener($offerApi, $this->createStub(ScxLogger::class));
        $listener->sendInFailed($event);
    }


    public function testCanSendInFailedWillFail(): void
    {
        $sellerIdStr = uniqid('sellerId');
        $sellerId = new ChannelSellerId($sellerIdStr);
        $sellerOfferId = random_int(1, 9999);
        $errorCode = uniqid('errorCode', true);
        $errorMsg = uniqid('errorMsg', true);
        $failedAt = new DateTime();
        $event = new SendOfferListingFailedMessage($sellerId, $sellerOfferId, $errorCode, $errorMsg, $failedAt);

        $offerApi = $this->createMock(OfferApi::class);
        $offerApi->expects(self::once())->method('markListingFailed')
            ->willThrowException($this->createStub(RequestFailedException::class));
        $listener = new SendOfferListingResultListener($offerApi, $this->createStub(ScxLogger::class));

        self::expectException(RequestFailedException::class);
        $listener->sendInFailed($event);
    }

    public function testCanSendSuccessful(): void
    {
        $sellerIdStr = uniqid('sellerId');
        $sellerId = new ChannelSellerId($sellerIdStr);
        $sellerOfferId = random_int(1, 9999);
        $channelOfferId = uniqid('channelOfferId', true);
        $listingUrl = uniqid('listingUrl', true);
        $listedAt = $this->createStub(DateTime::class);
        $event = new SendOfferListingSuccessfulMessage(
            $sellerId,
            $sellerOfferId,
            $channelOfferId,
            $listingUrl,
            $listedAt
        );

        $offerApi = $this->createMock(OfferApi::class);
        $offerApi->expects(self::once())->method('markListed')->with(self::callback(
            function (MarkListingSuccessfulRequest $request) use (
                $sellerIdStr,
                $sellerOfferId,
                $listedAt,
                $channelOfferId,
                $listingUrl
            ) {
                $json = $request->getBody();
                self::assertEquals(
                    [
                        'offerList' => [
                            [
                                'sellerId' => $sellerIdStr,
                                'offerId' => $sellerOfferId,
                                'listedAt' => $listedAt->format('c'),
                                'channelOfferId' => $channelOfferId,
                                'listingUrl' => $listingUrl,
                            ],
                        ],
                    ],
                    json_decode($json, true)
                );
                return true;
            }
        ));
        $listener = new SendOfferListingResultListener($offerApi, $this->createStub(ScxLogger::class));
        $listener->sendSuccessful($event);
    }

    public function testCanSendSuccessfulWillFail(): void
    {
        $sellerIdStr = uniqid('sellerId');
        $sellerId = new ChannelSellerId($sellerIdStr);
        $sellerOfferId = random_int(1, 9999);
        $channelOfferId = uniqid('channelOfferId', true);
        $listingUrl = uniqid('listingUrl', true);
        $listedAt = new DateTime();
        $event = new SendOfferListingSuccessfulMessage(
            $sellerId,
            $sellerOfferId,
            $channelOfferId,
            $listingUrl,
            $listedAt
        );

        $offerApi = $this->createMock(OfferApi::class);
        $offerApi->expects(self::once())->method('markListed')
            ->willThrowException($this->createStub(RequestFailedException::class));
        $listener = new SendOfferListingResultListener($offerApi, $this->createStub(ScxLogger::class));

        self::expectException(RequestFailedException::class);
        $listener->sendSuccessful($event);
    }

    public function testCanSendInProgressWillFail(): void
    {
        $sellerIdStr = uniqid('sellerId');
        $sellerId = new ChannelSellerId($sellerIdStr);
        $sellerOfferId = random_int(1, 9999);
        $startedAt = new DateTime();
        $event = new SendOfferListingInProgressMessage($sellerId, $sellerOfferId, $startedAt);

        $offerApi = $this->createMock(OfferApi::class);
        $offerApi->expects(self::once())->method('markInProgress')
            ->willThrowException($this->createStub(RequestFailedException::class));
        $listener = new SendOfferListingResultListener($offerApi, $this->createStub(ScxLogger::class));

        self::expectException(RequestFailedException::class);
        $listener->sendInProgress($event);
    }
}
