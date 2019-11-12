<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace MetaData\Attribute;

use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttribute;
use JTL\SCX\Lib\Channel\MetaData\Attribute\ConditionalCategoryAttribute;
use JTL\SCX\Lib\Channel\MetaData\Attribute\ConditionalCategoryAttributeCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class CategoryAttributeTest
 * @package MetaData\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttribute
 */
class CategoryAttributeTest extends TestCase
{
    public function testCanGetValues(): void
    {
        $conditionalAttributeId = uniqid('caid', true);
        $conditionalAttributeValues = [uniqid('enumValues', true)];

        $conditional = new ConditionalCategoryAttribute($conditionalAttributeId, $conditionalAttributeValues);
        $id = uniqid('id', true);
        $attributeId = uniqid('attributeId', true);
        $displayName = uniqid('displayName', true);
        $enumValues = [uniqid('enumValues', true)];
        $description = uniqid('description', true);
        $required = (bool)random_int(0, 1);
        $type = uniqid('type', true);
        $isMultipleAllowed = (bool)random_int(0, 1);
        $attributeValueValidation = uniqid('attributeValueValidation', true);
        $conditionalMandatoryBy = ConditionalCategoryAttributeCollection::from($conditional);
        $conditionalOptionalBy = ConditionalCategoryAttributeCollection::from($conditional);
        $section = uniqid('section', true);
        $sectionPosition = random_int(1, 10000);
        $subSection = random_int(1, 10000);
        $subSectionPosition = random_int(1, 10000);
        $isVariationDimension = (bool)random_int(0, 1);

        $attribute = new CategoryAttribute(
            $attributeId,
            $displayName,
            $description,
            $required,
            $enumValues,
            $type,
            $isMultipleAllowed,
            $attributeValueValidation,
            $conditionalMandatoryBy,
            $conditionalOptionalBy,
            $section,
            $sectionPosition,
            $subSection,
            $subSectionPosition,
            $isVariationDimension
        );

        $attribute->setId($id);

        $this->assertEquals($attributeId, $attribute->getAttributeId());
        $this->assertEquals($displayName, $attribute->getDisplayName());
        $this->assertEquals($type, $attribute->getType());
        $this->assertEquals($enumValues, $attribute->getEnumValues());
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
    }
}
