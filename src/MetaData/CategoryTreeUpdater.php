<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-10-31
 */

namespace JTL\SCX\Lib\Channel\MetaData;

use JTL\SCX\Client\Channel\Api\Category\Request\UpdateCategoryTreeRequest;
use JTL\SCX\Client\Channel\Api\Category\UpdateCategoryTreeApi;
use JTL\SCX\Client\Channel\Model\ChannelCategoryTree;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusExceprion;

class CategoryTreeUpdater
{
    /**
     * @var UpdateCategoryTreeApi
     */
    private $client;

    /**
     * @var CategoryMapper
     */
    private $categoryMapper;

    /**
     * CategoryTreeUpdater constructor.
     * @param UpdateCategoryTreeApi $client
     * @param CategoryMapper $categoryMapper
     */
    public function __construct(UpdateCategoryTreeApi $client, CategoryMapper $categoryMapper)
    {
        $this->client = $client;
        $this->categoryMapper = $categoryMapper;
    }

    /**
     * @param CategoryList $categoryList
     * @return string
     * @throws UnexpectedStatusExceprion
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JTL\SCX\Client\Exception\RequestFailedException
     * @throws \JTL\SCX\Client\Exception\RequestValidationFailedException
     */
    public function update(CategoryList $categoryList): string
    {
        $categoryTree = new ChannelCategoryTree();
        $categoryTree->setCategoryList($this->categoryMapper->map($categoryList));
        $request = new UpdateCategoryTreeRequest($categoryTree);

        $response = $this->client->update($request);

        if ($response->getStatusCode() !== 201) {
            throw new UnexpectedStatusExceprion("Could not update categoryTree. Request returned statuscode {$response->getStatusCode()}");
        }
        return $response->getCategoryTreeVersion()->getCategoryTreeVersion();
    }
}
