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
     * @param CategoryAttributeList $categoryAttributeList
     * @return array
     */
    public function map(CategoryAttributeList $categoryAttributeList): array
    {
        $list = [];

        foreach ($categoryAttributeList as $attribute) {
            $list[] = new Attribute([
                'attributeId' => $attribute->getAttributeId(),
                'displayName' => $attribute->getDisplayName(),
                'isMultipleAllowed' => $attribute->isMultipleAllowed(),
                'required' => $attribute->isRequired(),
                'type' => $attribute->getType(),
                'enumValues' => $attribute->getEnumValues(),
                'attributeValueValidation' => $attribute->getAttributeValueValidation(),
                // TODO: Fix this when EA-2546 is done
                'conditionalMandantoryBy' => null, //$attribute->getConditionalMandatoryBy(),
                'conditionalOptionalBy' => null, //$attribute->getConditionalOptionalBy(),
                'section' => $attribute->getSection(),
                'sectionPosition' => $attribute->getSectionPosition(),
                'subSection' => $attribute->getSubSection(),
                'subSectionPosition' => $attribute->getSubSectionPosition(),
                'description' => $attribute->getDescription(),
            ]);
        }

        return $list;
    }
}
