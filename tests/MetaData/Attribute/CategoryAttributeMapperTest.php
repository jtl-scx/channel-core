<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace MetaData\Attribute;

use JTL\SCX\Client\Channel\Model\Attribute;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttribute;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeList;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeMapper;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeTypeMapper;
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
        $typeMapper = new CategoryAttributeTypeMapper();
        $mapper = new CategoryAttributeMapper($typeMapper);

        $attributeId = random_int(1, 100000);
        $name = uniqid('name', true);
        $title = uniqid('title', true);
        $multiple = (bool)random_int(0, 1);
        $type = uniqid('type', true);
        $required = (bool)random_int(0, 1);

        $attribute = new CategoryAttribute(
            $attributeId,
            $name,
            $title,
            $multiple,
            $type,
            $required
        );

        $attributeList = CategoryAttributeList::from($attribute);

        $result = $mapper->map($attributeList);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(Attribute::class, $result[0]);
    }
}
