<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-08-17
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Meta;

use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\Meta\Request\CreatePaymentRulesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Meta\Response\CreatePaymentRulesResponse;

class PaymentRulesApi
{
    private AuthAwareApiClient $client;

    public function __construct(AuthAwareApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param CreatePaymentRulesRequest $request
     * @return CreatePaymentRulesResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JTL\SCX\Client\Exception\RequestFailedException
     */
    public function create(CreatePaymentRulesRequest $request): CreatePaymentRulesResponse
    {
        $response = $this->client->request($request);
        return new CreatePaymentRulesResponse($response->getStatusCode());
    }
}
