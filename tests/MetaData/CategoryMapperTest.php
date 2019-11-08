<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-11-04
 */

namespace JTL\SCX\Lib\Channel\MetaData;

use PHPUnit\Framework\TestCase;

/**
 * Class CategoryMapperTest
 * @package JTL\SCX\Lib\Channel\MetaData
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\CategoryMapper
 */
class CategoryMapperTest extends TestCase
{

    public function testMap(): void
    {
        $categoryList = new CategoryList();
        $categoryList[] = new Category('0', 'name0', 'parent0', false);
        $categoryList[] = new Category('1', 'name1', 'parent1', true);

        $mapper = new CategoryMapper();
        $result = $mapper->map($categoryList);

        $this->assertIsArray($result);
        $this->assertCount($categoryList->count(), $result);

        /** @var \JTL\SCX\Client\Channel\Model\Category $categoryModel */
        foreach ($result as $key => $categoryModel) {
            $this->assertSame((string)$key, $categoryModel->getCategoryId());
            $this->assertSame("name{$key}", $categoryModel->getDisplayName());
            $this->assertSame("parent{$key}", $categoryModel->getParentCategoryId());
            $this->assertSame((bool)$key, $categoryModel->getListingAllowed());
        }
    }
}
