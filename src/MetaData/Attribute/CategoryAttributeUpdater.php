<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/11/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Channel\Api\Attribute\CreateCategoryAttributesApi;
use JTL\SCX\Client\Channel\Api\Attribute\Request\CreateCategoryAttributesRequest;
use JTL\SCX\Client\Channel\Model\AttributeList;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Client\Exception\RequestValidationFailedException;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusExceprion;

class CategoryAttributeUpdater
{
    /**
     * @var CreateCategoryAttributesApi
     */
    private $client;

    /**
     * @var CategoryAttributeMapper
     */
    private $mapper;

    /**
     * CategoryAttributeUpdater constructor.
     * @param CreateCategoryAttributesApi $client
     * @param CategoryAttributeMapper $mapper
     */
    public function __construct(CreateCategoryAttributesApi $client, CategoryAttributeMapper $mapper)
    {
        $this->client = $client;
        $this->mapper = $mapper;
    }

    /**
     * @param string $categoryId
     * @param CategoryAttributeList $categoryAttributeList
     * @throws UnexpectedStatusExceprion
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws RequestValidationFailedException
     */
    public function update(string $categoryId, CategoryAttributeList $categoryAttributeList): void
    {
        $attributeList = new AttributeList();
        $attributeList->setAttributeList($this->mapper->map($categoryAttributeList));
        $request = new CreateCategoryAttributesRequest($categoryId, $attributeList);
        $response = $this->client->createCategoryAttributes($request);

        if ($response->getStatusCode() !== 201) {
            throw new UnexpectedStatusExceprion("Could not update category attributes. Request returned status code {$response->getStatusCode()}");
        }
    }
}
