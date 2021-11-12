<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/8/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Offer;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\Offer\Request\MarkListingAsFailedRequest;
use JTL\SCX\Lib\Channel\Client\Api\Offer\Request\MarkListingInProgressRequest;
use JTL\SCX\Lib\Channel\Client\Api\Offer\Request\MarkListingSuccessfulRequest;
use JTL\SCX\Client\Exception\RequestFailedException;

class OfferApi
{
    private AuthAwareApiClient $apiClient;

    public function __construct(AuthAwareApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
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
}
