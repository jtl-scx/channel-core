<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use PHPUnit\Framework\TestCase;

/**
 * Class AttributeTest
 * @package MetaData\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\Attribute
 */
class AttributeTest extends TestCase
{
    public function testCanGetValues(): void
    {
        $conditionalAttributeId = uniqid('caid', true);
        $conditionalAttributeValues = [uniqid('enumValues', true)];

        $conditional = new ConditionalAttribute($conditionalAttributeId, $conditionalAttributeValues);
        $value = new AttributeAllowedValue('value', 'display');
        $attributeId = uniqid('attributeId', true);
        $displayName = uniqid('displayName', true);
        $enumValues = [uniqid('enumValues', true)];
        $description = uniqid('description', true);
        $required = (bool)random_int(0, 1);
        $type = AttributeType::DECIMAL();
        $isMultipleAllowed = (bool)random_int(0, 1);
        $attributeValueValidation = uniqid('attributeValueValidation', true);
        $conditionalMandatoryBy = ConditionalAttributeList::from($conditional);
        $conditionalOptionalBy = ConditionalAttributeList::from($conditional);
        $values = AllowedValueCollection::from($value);
        $section = uniqid('section', true);
        $sectionPosition = random_int(1, 10000);
        $subSection = uniqid('subsection', true);
        $subSectionPosition = random_int(1, 10000);
        $isVariationDimension = (bool)random_int(0, 1);
        $isRecommended = (bool)random_int(0, 1);

        $attribute = new Attribute(
            $attributeId,
            $displayName,
            $description,
            $required,
            $enumValues,
            $values,
            $type,
            $isMultipleAllowed,
            $attributeValueValidation,
            $conditionalMandatoryBy,
            $conditionalOptionalBy,
            $section,
            $sectionPosition,
            $subSection,
            $subSectionPosition,
            $isVariationDimension,
            $isRecommended
        );

        $this->assertEquals($attributeId, $attribute->getAttributeId());
        $this->assertEquals($displayName, $attribute->getDisplayName());
        $this->assertEquals($type, $attribute->getType());
        $this->assertEquals($enumValues, $attribute->getEnumValues());
        $this->assertEquals($values, $attribute->getValues());
        $this->assertEquals($attributeValueValidation, $attribute->getAttributeValueValidation());
        $this->assertEquals($conditionalMandatoryBy, $attribute->getConditionalMandatoryBy());
        $this->assertEquals($conditionalOptionalBy, $attribute->getConditionalOptionalBy());
        $this->assertEquals($section, $attribute->getSection());
        $this->assertEquals($sectionPosition, $attribute->getSectionPosition());
        $this->assertEquals($subSection, $attribute->getSubSection());
        $this->assertEquals($subSectionPosition, $attribute->getSubSectionPosition());
        $this->assertEquals($description, $attribute->getDescription());
        $this->assertEquals($required, $attribute->isRequired());
        $this->assertEquals($isMultipleAllowed, $attribute->isMultipleAllowed());
        $this->assertEquals($isVariationDimension, $attribute->isVariationDimension());
        $this->assertEquals($isRecommended, $attribute->isRecommended());
    }
}
