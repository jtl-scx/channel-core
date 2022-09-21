<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Category;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\Category\Request\UpdateCategoryTreeRequest;
use JTL\SCX\Lib\Channel\Client\Api\Category\Response\UpdateCategoryTreeResponse;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Client\Model\CategoryTreeVersion;
use JTL\SCX\Client\Exception\RequestFailedException;

class CategoryApi
{
    private AuthAwareApiClient $apiClient;
    private ChannelApiResponseDeserializer $responseDeserializer;

    public function __construct(
        AuthAwareApiClient $apiClient,
        ChannelApiResponseDeserializer $responseDeserializer = null
    ) {
        $this->apiClient = $apiClient;
        $this->responseDeserializer = $responseDeserializer ?? new ChannelApiResponseDeserializer();
    }

    /**
     * @param UpdateCategoryTreeRequest $request
     * @return UpdateCategoryTreeResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function updateCategoryTree(UpdateCategoryTreeRequest $request): UpdateCategoryTreeResponse
    {
        $response = $this->apiClient->request($request);

        /** @var CategoryTreeVersion $categoryTreeVersion */
        $categoryTreeVersion = $this->responseDeserializer->deserialize($response, CategoryTreeVersion::class);

        return new UpdateCategoryTreeResponse($response->getStatusCode(), $categoryTreeVersion);
    }
}
