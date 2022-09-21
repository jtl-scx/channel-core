<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Attribute;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\CreateCategoryAttributesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\CreateGlobalAttributesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\CreateSellerAttributesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\DeleteCategoryAttributesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\DeleteGlobalAttributeRequest;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\Response\AttributesCreatedResponse;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\Response\AttributesDeletedResponse;
use JTL\SCX\Client\Exception\RequestFailedException;

class AttributesApi
{
    private AuthAwareApiClient $apiClient;

    public function __construct(AuthAwareApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @param CreateCategoryAttributesRequest $request
     * @return AttributesCreatedResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function createCategoryAttributes(CreateCategoryAttributesRequest $request): AttributesCreatedResponse
    {
        $response = $this->apiClient->request($request);
        return new AttributesCreatedResponse($response->getStatusCode());
    }

    /**
     * @param CreateGlobalAttributesRequest $request
     * @return AttributesCreatedResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function createGlobalAttributes(CreateGlobalAttributesRequest $request): AttributesCreatedResponse
    {
        $response = $this->apiClient->request($request);
        return new AttributesCreatedResponse($response->getStatusCode());
    }

    /**
     * @param CreateSellerAttributesRequest $request
     * @return AttributesCreatedResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function createSellerAttributes(CreateSellerAttributesRequest $request): AttributesCreatedResponse
    {
        $response = $this->apiClient->request($request);
        return new AttributesCreatedResponse($response->getStatusCode());
    }

    /**
     * @param DeleteGlobalAttributeRequest $request
     * @return AttributesDeletedResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function deleteGlobalAttribute(DeleteGlobalAttributeRequest $request): AttributesDeletedResponse
    {
        $response = $this->apiClient->request($request);
        return new AttributesDeletedResponse($response->getStatusCode());
    }

    /**
     * @param string $categoryId
     * @return AttributesDeletedResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function deleteCategoryAttributes(string $categoryId): AttributesDeletedResponse
    {
        $response = $this->apiClient->request(new DeleteCategoryAttributesRequest($categoryId));
        return new AttributesDeletedResponse($response->getStatusCode());
    }
}
