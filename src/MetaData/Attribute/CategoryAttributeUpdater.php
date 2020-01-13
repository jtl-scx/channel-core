<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/11/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Channel\Api\Attribute\AttributesApi;
use JTL\SCX\Client\Channel\Api\Attribute\Request\CreateCategoryAttributesRequest;
use JTL\SCX\Client\Channel\Model\AttributeList as ClientAttributeList;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Client\Exception\RequestValidationFailedException;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusException;

class CategoryAttributeUpdater
{
    private AttributesApi $client;
    private AttributeMapper $mapper;

    public function __construct(AttributesApi $client, AttributeMapper $mapper)
    {
        $this->client = $client;
        $this->mapper = $mapper;
    }

    /**
     * @param string $categoryId
     * @param AttributeList $categoryAttributeList
     * @throws UnexpectedStatusException
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws RequestValidationFailedException
     */
    public function update(string $categoryId, AttributeList $categoryAttributeList): void
    {
        $attributeList = new ClientAttributeList();
        $attributeList->setAttributeList($this->mapper->map($categoryAttributeList));
        $request = new CreateCategoryAttributesRequest($categoryId, $attributeList);
        $response = $this->client->createCategoryAttributes($request);

        if ($response->getStatusCode() !== 201) {
            throw new UnexpectedStatusException("Could not update category attributes. Request returned status code {$response->getStatusCode()}");
        }
    }
}
