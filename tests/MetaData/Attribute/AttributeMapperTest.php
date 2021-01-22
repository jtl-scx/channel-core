<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Client\Channel\Model\Attribute as ScxAttribute;
use PHPUnit\Framework\TestCase;

/**
 * Class AttributeMapperTest
 * @package MetaData\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeMapper
 */
class AttributeMapperTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_map_to_SCX_Attribute_Model(): void
    {
        $mapper = new AttributeMapper();

        $attribute1 = $this->createFakeAttribute();
        $attribute2 = $this->createFakeAttribute();

        $attributeList = AttributeList::from($attribute1, $attribute2);
        $result = $mapper->map($attributeList);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(ScxAttribute::class, $result[0]);
        $this->assertInstanceOf(ScxAttribute::class, $result[1]);
    }

    private function createFakeAttribute(): Attribute
    {
        $conditionalAttributeId = uniqid('caid', true);
        $conditionalAttributeValues = [uniqid('enumValues', true)];

        $conditional = new ConditionalAttribute($conditionalAttributeId, $conditionalAttributeValues);
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
        $section = uniqid('section', true);
        $sectionPosition = random_int(1, 10000);
        $subSection = uniqid('subsection', true);
        $subSectionPosition = random_int(1, 10000);
        $isVariationDimension = (bool)random_int(0, 1);
        $isRecommended = (bool)random_int(0, 1);

        return new Attribute(
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
            $isVariationDimension,
            $isRecommended
        );
    }
}
