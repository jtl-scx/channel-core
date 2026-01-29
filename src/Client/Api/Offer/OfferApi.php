<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/8/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Offer;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Client\Api\Offer\Request\GetAllStockUpdatesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Offer\Request\GetStockUpdatesBySellerRequest;
use JTL\SCX\Lib\Channel\Client\Api\Offer\Request\MarkListingAsFailedRequest;
use JTL\SCX\Lib\Channel\Client\Api\Offer\Request\MarkListingInProgressRequest;
use JTL\SCX\Lib\Channel\Client\Api\Offer\Request\MarkListingSuccessfulRequest;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Lib\Channel\Client\Api\Offer\Response\GetStockUpdatesResponse;
use JTL\SCX\Lib\Channel\Client\Model\StockList;

class OfferApi
{
    public function __construct(
        private readonly AuthAwareApiClient $apiClient,
        private readonly ChannelApiResponseDeserializer $channelApiResponseDeserializer
    ) {
    }

    /**
     * @param MarkListingInProgressRequest $request
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function markInProgress(MarkListingInProgressRequest $request): void
    {
        $this->apiClient->request($request);
    }

    /**
     * @param MarkListingSuccessfulRequest $request
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function markListed(MarkListingSuccessfulRequest $request): void
    {
        $this->apiClient->request($request);
    }

    /**
     * @param MarkListingAsFailedRequest $request
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function markListingFailed(MarkListingAsFailedRequest $request): void
    {
        $this->apiClient->request($request);
    }

    /**
     * @throws RequestFailedException
     * @throws GuzzleException
     */
    public function getAllStockUpdates(GetAllStockUpdatesRequest $request): GetStockUpdatesResponse
    {
        $response = $this->apiClient->request($request);
        /** @var StockList $stockList */
        $stockList =  $this->channelApiResponseDeserializer->deserialize($response, StockList::class);

        return new GetStockUpdatesResponse($stockList, $response->getStatusCode());
    }

    /**
     * @throws RequestFailedException
     * @throws GuzzleException
     */
    public function getStockUpdatesBySeller(GetStockUpdatesBySellerRequest $request): GetStockUpdatesResponse
    {
        $response = $this->apiClient->request($request);
        /** @var StockList $stockList */
        $stockList =  $this->channelApiResponseDeserializer->deserialize($response, StockList::class);

        return new GetStockUpdatesResponse($stockList, $response->getStatusCode());
    }
}
