<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Client\Channel\Model\Attribute as ClientAttribute;
use PHPUnit\Framework\TestCase;

/**
 * Class AttributeMapperTest
 * @package MetaData\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeMapper
 */
class AttributeMapperTest extends TestCase
{
    public function testCanMap(): void
    {
        $mapper = new AttributeMapper();

        $attributeId = uniqid('attributeId', true);
        $name = uniqid('name', true);
        $title = uniqid('title', true);
        $required = (bool)random_int(0, 1);

        $attribute = new Attribute(
            $attributeId,
            $name,
            $title,
            $required,
            null,
            AttributeType::TEXT()
        );

        $attributeList = AttributeList::from($attribute);

        $result = $mapper->map($attributeList);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(ClientAttribute::class, $result[0]);
    }
}
