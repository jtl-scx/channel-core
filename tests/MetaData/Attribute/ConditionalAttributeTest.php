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
 * Class ConditionalAttributeTest
 * @package MetaData\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\ConditionalAttribute
 */
class ConditionalAttributeTest extends TestCase
{
    public function testCanGetValues(): void
    {
        $attributeId = uniqid('attributeId', true);
        $attributeValue = uniqid('attributeValue', true);
        $attributeValues = [$attributeValue];

        $conditional = new ConditionalAttribute($attributeId, $attributeValues);

        $this->assertEquals($attributeId, $conditional->getAttributeId());
        $this->assertCount(1, $conditional->getAttributeValues());
        $this->assertSame($attributeValue, $conditional->getAttributeValues()[0]);
    }
}
