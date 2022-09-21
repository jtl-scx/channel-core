<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-11-04
 */

namespace JTL\SCX\Lib\Channel\MetaData;

use PHPUnit\Framework\TestCase;

/**
 * Class CategoryTest
 * @package \JTL\SCX\Lib\Channel\MetaData
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Category
 */
class CategoryTest extends TestCase
{
    /**
     * @var Category
     */
    private $category;

    /**
     * @var string
     */
    private $categoryId;

    /**
     * @var string
     */
    private $categoryName;

    /**
     * @var string
     */
    private $parentCategoryId;

    /**
     * @var bool
     */
    private $listingAllowed;

    public function setUp(): void
    {
        $this->categoryId = uniqid('catId', true);
        $this->categoryName = uniqid('categoryName', true);
        $this->parentCategoryId = uniqid('parentCategoryId', true);
        $this->listingAllowed = false;

        $this->category = new Category(
            $this->categoryId,
            $this->categoryName,
            $this->parentCategoryId,
            $this->listingAllowed
        );
    }

    public function testCanBeCreatedWithoutListingAllowedParam(): void
    {
        $category = new Category(
            $this->categoryId,
            $this->categoryName,
            $this->parentCategoryId
        );

        $this->assertInstanceOf(Category::class, $category);
        $this->assertTrue($category->isListingAllowed());
    }

    public function testIsListingAllowed(): void
    {
        $this->assertFalse($this->category->isListingAllowed());
    }

    public function testGetCategoryName(): void
    {
        $this->assertSame($this->categoryName, $this->category->getCategoryName());
    }

    public function testGetCategoryId(): void
    {
        $this->assertSame($this->categoryId, $this->category->getCategoryId());
    }

    public function testGetParentCategoryId(): void
    {
        $this->assertSame($this->parentCategoryId, $this->category->getParentCategoryId());
    }
}
