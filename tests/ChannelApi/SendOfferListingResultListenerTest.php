<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace ChannelApi;

use JTL\SCX\Client\Channel\Api\Offer\OfferApi;
use JTL\SCX\Client\Channel\Api\Offer\Request\MarkListingAsFailedRequest;
use JTL\SCX\Client\Channel\Api\Offer\Request\MarkListingInProgressRequest;
use JTL\SCX\Client\Channel\Api\Offer\Request\MarkListingSuccessfulRequest;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingFailedMessage;
use JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingInProgressMessage;
use JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingResultListener;
use JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingSuccessfulMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingResultListener
 *
 * @uses   \JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingInProgressMessage
 * @uses   \JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingFailedMessage
 * @uses   \JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingSuccessfulMessage
 * @uses   \JTL\SCX\Lib\Channel\Seller\ChannelSellerId
 */
class SendOfferListingResultListenerTest extends TestCase
{
    public function testCanSendInFailed(): void
    {
        $sellerIdStr = uniqid('sellerId');
        $sellerId = new ChannelSellerId($sellerIdStr);
        $sellerOfferId = (string)random_int(1, 9999);
        $errorCode = uniqid('errorCode', true);
        $errorMsg = uniqid('errorMsg', true);
        $failedAt = new \DateTime();
        $event = new SendOfferListingFailedMessage($sellerId, $sellerOfferId, $errorCode, $errorMsg, $failedAt);

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
                                    ['code' => $errorCode, 'message' => $errorMsg]
                                ]
                            ]
                        ]
                    ],
                    json_decode($json, true)
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
        $sellerOfferId = (string)random_int(1, 9999);
        $errorCode = uniqid('errorCode', true);
        $errorMsg = uniqid('errorMsg', true);
        $failedAt = new \DateTime();
        $event = new SendOfferListingFailedMessage($sellerId, $sellerOfferId, $errorCode, $errorMsg, $failedAt);

        $offerApi = $this->createMock(OfferApi::class);
        $offerApi->expects(self::once())->method('markListingFailed')
            ->willThrowException($this->createStub(RequestFailedException::class));
        $listener = new SendOfferListingResultListener($offerApi, $this->createStub(ScxLogger::class));
        $listener->sendInFailed($event);
    }

    public function testCanSendSuccessful(): void
    {
        $sellerIdStr = uniqid('sellerId');
        $sellerId = new ChannelSellerId($sellerIdStr);
        $sellerOfferId = (string)random_int(1, 9999);
        $channelOfferId = uniqid('channelOfferId', true);
        $listingUrl = uniqid('listingUrl', true);
        $listedAt = new \DateTime();
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
                                'listingUrl' => $listingUrl
                            ]
                        ]
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
        $sellerOfferId = (string)random_int(1, 9999);
        $channelOfferId = uniqid('channelOfferId', true);
        $listingUrl = uniqid('listingUrl', true);
        $listedAt = new \DateTime();
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
        $listener->sendSuccessful($event);
    }

    public function testCanSendInProgressWillFail(): void
    {
        $sellerIdStr = uniqid('sellerId');
        $sellerId = new ChannelSellerId($sellerIdStr);
        $sellerOfferId = (string)random_int(1, 9999);
        $startedAt = new \DateTime();
        $event = new SendOfferListingInProgressMessage($sellerId, $sellerOfferId, $startedAt);

        $offerApi = $this->createMock(OfferApi::class);
        $offerApi->expects(self::once())->method('markInProgress')
            ->willThrowException($this->createStub(RequestFailedException::class));
        $listener = new SendOfferListingResultListener($offerApi, $this->createStub(ScxLogger::class));
        $listener->sendInProgress($event);
    }
}
