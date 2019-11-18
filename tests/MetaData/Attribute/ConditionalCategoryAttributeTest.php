<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace MetaData\Attribute;

use JTL\SCX\Lib\Channel\MetaData\Attribute\ConditionalCategoryAttribute;
use PHPUnit\Framework\TestCase;

/**
 * Class ConditionalCategoryAttributeTest
 * @package MetaData\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\ConditionalCategoryAttribute
 */
class ConditionalCategoryAttributeTest extends TestCase
{
    public function testCanGetValues(): void
    {
        $attributeId = uniqid('attributeId', true);
        $attributeValue = uniqid('attributeValue', true);
        $attributeValues = [$attributeValue];

        $conditional = new ConditionalCategoryAttribute($attributeId, $attributeValues);

        $this->assertEquals($attributeId, $conditional->getAttributeId());
        $this->assertCount(1, $conditional->getAttributeValues());
        $this->assertSame($attributeValue, $conditional->getAttributeValues()[0]);
    }
}
