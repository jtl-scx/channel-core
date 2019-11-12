<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/11/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Client\Channel\Model\Attribute;

class CategoryAttributeMapper
{
    /**
     * @var CategoryAttributeTypeMapper
     */
    private $typeMapper;

    /**
     * CategoryAttributeMapper constructor.
     * @param CategoryAttributeTypeMapper $typeMapper
     */
    public function __construct(CategoryAttributeTypeMapper $typeMapper)
    {
        $this->typeMapper = $typeMapper;
    }

    public function map(CategoryAttributeList $categoryAttributeList): array
    {
        $list = [];

        foreach ($categoryAttributeList as $attribute) {
            $list[] = new Attribute([
                'attributeId' => $attribute->getName(),
                'displayName' => $attribute->getTitle(),
                'isMultipleAllowed' => $attribute->isMultipleAllowed(),
                'required' => $attribute->isRequired(),
                'type' => $this->typeMapper->map($attribute->getType())
            ]);
        }

        return $list;
    }
}
