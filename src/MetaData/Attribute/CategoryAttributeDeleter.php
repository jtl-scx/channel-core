<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 8/31/21
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Channel\Api\Attribute\AttributesApi;
use JTL\SCX\Client\Channel\Api\Attribute\Request\DeleteCategoryAttributesRequest;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusException;

class CategoryAttributeDeleter
{
    private AttributesApi $client;

    public function __construct(AttributesApi $client)
    {
        $this->client = $client;
    }

    /**
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws UnexpectedStatusException
     */
    public function delete(): void
    {
        $request = new DeleteCategoryAttributesRequest();
        $response = $this->client->deleteCategoryAttributes($request);

        if ($response->getStatusCode() !== 201) {
            throw new UnexpectedStatusException("Could not delete category attributes. Request returned status code {$response->getStatusCode()}");
        }
    }
}
