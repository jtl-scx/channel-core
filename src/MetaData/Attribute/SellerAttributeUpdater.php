<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-02
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\AttributesApi;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\CreateSellerAttributesRequest;
use JTL\SCX\Lib\Channel\Client\Model\AttributeList as ClientAttributeList;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Client\Exception\RequestValidationFailedException;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusException;

class SellerAttributeUpdater
{
    private AttributesApi $client;
    private AttributeMapper $attributeMapper;

    public function __construct(AttributesApi $client, AttributeMapper $attributeMapper)
    {
        $this->client = $client;
        $this->attributeMapper = $attributeMapper;
    }

    /**
     * @param string $sellerId
     * @param AttributeList $attributeList
     * @throws UnexpectedStatusException
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws RequestValidationFailedException
     */
    public function update(string $sellerId, AttributeList $attributeList): void
    {
        $clientAttributeList = new ClientAttributeList();
        $clientAttributeList->setAttributeList($this->attributeMapper->map($attributeList));
        $request = new CreateSellerAttributesRequest($sellerId, $clientAttributeList);
        $response = $this->client->createSellerAttributes($request);

        if ($response->getStatusCode() !== 201) {
            throw new UnexpectedStatusException("Could not update seller attributes. Request returned status code {$response->getStatusCode()}");
        }
    }
}
