<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-18
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

class CategoryAttribute
{
    private string $categoryId;
    private AttributeList $attributeList;

    public function __construct(string $categoryId, AttributeList $attributeList)
    {
        $this->categoryId = $categoryId;
        $this->attributeList = $attributeList;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function getAttributeList(): AttributeList
    {
        return $this->attributeList;
    }
}
