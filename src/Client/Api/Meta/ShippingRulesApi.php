<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-08-17
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Meta;

use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\Meta\Request\CreateShippingRulesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Meta\Request\PutSellerShippingRulesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Meta\Response\CreateShippingRulesResponse;
use JTL\SCX\Lib\Channel\Client\Api\Meta\Response\PutSellerShippingRulesResponse;

class ShippingRulesApi
{
    private AuthAwareApiClient $client;

    public function __construct(AuthAwareApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param CreateShippingRulesRequest $request
     * @return CreateShippingRulesResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JTL\SCX\Client\Exception\RequestFailedException
     */
    public function create(CreateShippingRulesRequest $request): CreateShippingRulesResponse
    {
        $response = $this->client->request($request);
        return new CreateShippingRulesResponse($response->getStatusCode());
    }

    /**
     * EA-8054: Set seller specific channel shipping attributes for a single seller.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JTL\SCX\Client\Exception\RequestFailedException
     */
    public function putSellerShippingRules(PutSellerShippingRulesRequest $request): PutSellerShippingRulesResponse
    {
        $response = $this->client->request($request);
        return new PutSellerShippingRulesResponse($response->getStatusCode());
    }
}
