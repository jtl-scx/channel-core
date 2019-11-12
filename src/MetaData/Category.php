<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-10-28
 */

namespace JTL\SCX\Lib\Channel\MetaData;

class Category
{
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

    /**
     * Category constructor.
     * @param string $categoryId
     * @param string $categoryName
     * @param string $parentCategoryId
     * @param bool $listingAllowed
     */
    public function __construct(
        string $categoryId,
        string $categoryName,
        string $parentCategoryId,
        bool $listingAllowed = true
    ) {
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
        $this->parentCategoryId = $parentCategoryId;
        $this->listingAllowed = $listingAllowed;
    }

    /**
     * @return string
     */
    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    /**
     * @return string
     */
    public function getCategoryName(): string
    {
        return $this->categoryName;
    }

    /**
     * @return string
     */
    public function getParentCategoryId(): string
    {
        return $this->parentCategoryId;
    }

    /**
     * @return bool
     */
    public function isListingAllowed(): bool
    {
        return $this->listingAllowed;
    }
}
