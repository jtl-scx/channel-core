<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-10-31
 */

namespace JTL\SCX\Lib\Channel\MetaData;

use JTL\SCX\Client\Channel\Model\Category;

class CategoryMapper
{
    /**
     * @param CategoryList $categoryList
     * @return array
     */
    public function map(CategoryList $categoryList): array
    {
        $categoryModelList = [];
        foreach ($categoryList as $category) {
            $categoryModelList[] = new Category([
                'categoryId' => $category->getCategoryId(),
                'displayName' => $category->getCategoryName(),
                'parentCategoryId' => $category->getParentCategoryId(),
                'listingAllowed' => $category->isListingAllowed(),
            ]);
        }
        return $categoryModelList;
    }
}
