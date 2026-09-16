<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/9/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Offer;

use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\Attributes\CoversClass;
use DateTime;
use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Client\Api\Offer\Request\GetAllStockUpdatesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Offer\Request\GetStockUpdatesBySellerRequest;
use JTL\SCX\Lib\Channel\Client\Api\Offer\Request\MarkListingAsFailedRequest;
use JTL\SCX\Lib\Channel\Client\Api\Offer\Request\MarkListingInProgressRequest;
use JTL\SCX\Lib\Channel\Client\Api\Offer\Request\MarkListingSuccessfulRequest;
use JTL\SCX\Lib\Channel\Client\Model\Stock;
use JTL\SCX\Lib\Channel\Client\Model\StockList;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class OfferApiTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Offer
 */
#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Offer\OfferApi::class)]
class OfferApiTest extends TestCase
{
    private ChannelApiResponseDeserializer&MockObject $deserializer;
    public function setUp(): void
    {
        $this->deserializer = $this->createMock(ChannelApiResponseDeserializer::class);
        parent::setUp();
    }

    #[AllowMockObjectsWithoutExpectations]
    public function testCanMarkInProgress(): void
    {
        $requestMock = $this->createStub(MarkListingInProgressRequest::class);
        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock);

        $api = new OfferApi($apiClientMock, $this->deserializer);
        $api->markInProgress($requestMock);
    }

    #[AllowMockObjectsWithoutExpectations]
    public function testMarkListingFailed(): void
    {
        $requestMock = $this->createStub(MarkListingAsFailedRequest::class);
        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock);

        $api = new OfferApi($apiClientMock, $this->deserializer);
        $api->markListingFailed($requestMock);
    }

    #[AllowMockObjectsWithoutExpectations]
    public function testMarkListed(): void
    {
        $requestMock = $this->createStub(MarkListingSuccessfulRequest::class);
        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock);

        $api = new OfferApi($apiClientMock, $this->deserializer);
        $api->markListed($requestMock);
    }

    public function testCanGetAllStockUpdates(): void
    {
        $dateTime = new DateTime();
        $requestMock = $this->createStub(GetAllStockUpdatesRequest::class);
        $stockList = new StockList([
            'lastUpdatedAt' => $dateTime,
            'stockUpdateList' => [new Stock([
                'sellerId' => 'sellerId',
                'offerId' => 123,
                'channelOfferId' => 'channelOfferId',
                'quantity' => 1,
                'updatedAt' => $dateTime,
            ])]
        ]);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock);
        $this->deserializer->expects($this->once())->method('deserialize')->willReturn($stockList);

        $api = new OfferApi($apiClientMock, $this->deserializer);
        $responseData = $api->getAllStockUpdates($requestMock)->getStockList();
        $this->assertCount(1, $responseData->getStockUpdateList());
        $this->assertSame($dateTime, $responseData->getLastUpdatedAt());
        $this->assertSame('sellerId', $responseData->getStockUpdateList()[0]->getSellerId());
        $this->assertSame(123, $responseData->getStockUpdateList()[0]->getOfferId());
        $this->assertSame('channelOfferId', $responseData->getStockUpdateList()[0]->getChannelOfferId());
        $this->assertSame(1, $responseData->getStockUpdateList()[0]->getQuantity());
        $this->assertSame($dateTime, $responseData->getStockUpdateList()[0]->getUpdatedAt());
    }

    public function testCanGetStockUpdatesBySeller(): void
    {
        $dateTime = new DateTime();
        $requestMock = $this->createStub(GetStockUpdatesBySellerRequest::class);
        $stockList = new StockList([
            'lastUpdatedAt' => $dateTime,
            'stockUpdateList' => [new Stock([
                'sellerId' => 'sellerId',
                'offerId' => 123,
                'channelOfferId' => 'channelOfferId',
                'quantity' => 1,
                'updatedAt' => $dateTime,
            ])]
        ]);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock);
        $this->deserializer->expects($this->once())->method('deserialize')->willReturn($stockList);

        $api = new OfferApi($apiClientMock, $this->deserializer);
        $responseData = $api->getStockUpdatesBySeller($requestMock)->getStockList();
        $this->assertCount(1, $responseData->getStockUpdateList());
        $this->assertSame($dateTime, $responseData->getLastUpdatedAt());
        $this->assertSame('sellerId', $responseData->getStockUpdateList()[0]->getSellerId());
        $this->assertSame(123, $responseData->getStockUpdateList()[0]->getOfferId());
        $this->assertSame('channelOfferId', $responseData->getStockUpdateList()[0]->getChannelOfferId());
        $this->assertSame(1, $responseData->getStockUpdateList()[0]->getQuantity());
        $this->assertSame($dateTime, $responseData->getStockUpdateList()[0]->getUpdatedAt());
    }
}
