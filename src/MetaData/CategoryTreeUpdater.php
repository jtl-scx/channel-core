<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-10-31
 */

namespace JTL\SCX\Lib\Channel\MetaData;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Lib\Channel\Client\Api\Category\CategoryApi;
use JTL\SCX\Lib\Channel\Client\Api\Category\Request\UpdateCategoryTreeRequest;
use JTL\SCX\Lib\Channel\Client\Model\ChannelCategoryTree;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Client\Exception\RequestValidationFailedException;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusException;

class CategoryTreeUpdater
{
    private CategoryApi $client;
    private CategoryMapper $categoryMapper;

    public function __construct(CategoryApi $client, CategoryMapper $categoryMapper)
    {
        $this->client = $client;
        $this->categoryMapper = $categoryMapper;
    }

    /**
     * @param CategoryList $categoryList
     * @return string
     * @throws UnexpectedStatusException
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws RequestValidationFailedException
     */
    public function update(CategoryList $categoryList): string
    {
        $categoryTree = new ChannelCategoryTree();
        $categoryTree->setCategoryList($this->categoryMapper->map($categoryList));
        $request = new UpdateCategoryTreeRequest($categoryTree);

        $response = $this->client->updateCategoryTree($request);

        if ($response->getStatusCode() !== 201) {
            throw new UnexpectedStatusException("Could not update categoryTree. Request returned statuscode {$response->getStatusCode()}");
        }
        return $response->getCategoryTreeVersion()->getCategoryTreeVersion();
    }
}
