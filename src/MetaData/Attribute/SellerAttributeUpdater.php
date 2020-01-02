<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-02
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Client\Channel\Api\Attribute\CreateSellerAttributesApi;
use JTL\SCX\Client\Channel\Api\Attribute\Request\CreateSellerAttributesRequest;
use JTL\SCX\Client\Channel\Model\AttributeList as ClientAttributeList;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusExceprion;

class SellerAttributeUpdater
{
    /**
     * @var CreateSellerAttributesApi
     */
    private $client;

    /**
     * @var AttributeMapper
     */
    private $attributeMapper;

    public function __construct(CreateSellerAttributesApi $client, AttributeMapper $attributeMapper)
    {
        $this->client = $client;
        $this->attributeMapper = $attributeMapper;
    }

    /**
     * @param string $sellerId
     * @param AttributeList $attributeList
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JTL\SCX\Client\Exception\RequestFailedException
     * @throws \JTL\SCX\Client\Exception\RequestValidationFailedException
     */
    public function update(string $sellerId, AttributeList $attributeList): void
    {
        $clientAttributeList = new ClientAttributeList();
        $clientAttributeList->setAttributeList($this->attributeMapper->map($attributeList));
        $request = new CreateSellerAttributesRequest($sellerId, $clientAttributeList);
        $response = $this->client->createSellerAttributes($request);

        if ($response->getStatusCode() !== 201) {
            throw new UnexpectedStatusExceprion("Could not update seller attributes. Request returned status code {$response->getStatusCode()}");
        }
    }
}