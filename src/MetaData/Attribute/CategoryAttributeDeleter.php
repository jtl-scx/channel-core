<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 8/31/21
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\AttributesApi;
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
    public function delete(string $categoryId): void
    {
        $response = $this->client->deleteCategoryAttributes($categoryId);
        if (!$response->isSuccessful()) {
            throw new UnexpectedStatusException("Could not delete category attributes. Request returned status code {$response->getStatusCode()}");
        }
    }
}
