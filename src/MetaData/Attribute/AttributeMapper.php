<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/11/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Lib\Channel\Client\Model\Attribute as ScxAttribute;

class AttributeMapper
{
    /**
     * @param AttributeList $categoryAttributeList
     * @return array
     */
    public function map(AttributeList $categoryAttributeList): array
    {
        $list = [];

        /** @var Attribute $attribute */
        foreach ($categoryAttributeList as $attribute) {
            $values = $attribute->getValues();
            $list[] = new ScxAttribute([
                'attributeId' => $attribute->getAttributeId(),
                'displayName' => $attribute->getDisplayName(),
                'isMultipleAllowed' => $attribute->isMultipleAllowed(),
                'required' => $attribute->isRequired(),
                'recommended' => $attribute->isRecommended(),
                'type' => (string)$attribute->getType(),
                'enumValues' => $attribute->getEnumValues(),
                'values' => $values !== null ? $values->toArray() : null,
                'attributeValueValidation' => $attribute->getAttributeValueValidation(),
                'conditionalMandantoryBy' => $this->mapConditional($attribute->getConditionalMandatoryBy()),
                'conditionalOptionalBy' => $this->mapConditional($attribute->getConditionalOptionalBy()),
                'section' => $attribute->getSection(),
                'sectionPosition' => $attribute->getSectionPosition(),
                'subSection' => $attribute->getSubSection(),
                'subSectionPosition' => $attribute->getSubSectionPosition(),
                'description' => $attribute->getDescription(),
                'isVariationDimension' => $attribute->isVariationDimension(),
            ]);
        }

        return $list;
    }

    private function mapConditional(?ConditionalAttributeList $conditionalAttributeCollection): ?array
    {
        if ($conditionalAttributeCollection === null) {
            return null;
        }
        $conditionalAttributeList = [];
        foreach ($conditionalAttributeCollection as $conditioanlAttribute) {
            $conditionalAttributeList[] = [
                'attributeId' => $conditioanlAttribute->getAttributeId(),
                'attributeValues' => $conditioanlAttribute->getAttributeValues(),
            ];
        }
        return $conditionalAttributeList;
    }
}
