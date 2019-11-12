<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace MetaData\Attribute;

use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttribute;
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

        $this->assertEquals($attributeId, $attribute->getAttributeId());
        $this->assertEquals($name, $attribute->getName());
        $this->assertEquals($title, $attribute->getTitle());
        $this->assertEquals($multiple, $attribute->isMultipleAllowed());
        $this->assertEquals($type, $attribute->getType());
        $this->assertEquals($required, $attribute->isRequired());
    }
}
