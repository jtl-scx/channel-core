<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace MetaData\Attribute;

use JTL\SCX\Client\Channel\Model\Attribute;
use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeType;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttribute;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeList;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeMapper;
use PHPUnit\Framework\TestCase;

/**
 * Class CategoryAttributeMapperTest
 * @package MetaData\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeMapper
 */
class CategoryAttributeMapperTest extends TestCase
{
    public function testCanMap(): void
    {
        $mapper = new CategoryAttributeMapper();

        $attributeId = uniqid('attributeId', true);
        $name = uniqid('name', true);
        $title = uniqid('title', true);
        $required = (bool)random_int(0, 1);

        $attribute = new CategoryAttribute(
            $attributeId,
            $name,
            $title,
            $required,
            null,
            AttributeType::TEXT()
        );

        $attributeList = CategoryAttributeList::from($attribute);

        $result = $mapper->map($attributeList);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(Attribute::class, $result[0]);
    }
}
