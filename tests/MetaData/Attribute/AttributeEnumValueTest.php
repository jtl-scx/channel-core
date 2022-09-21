<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-03-10
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeEnumValue
 */
class AttributeEnumValueTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $enumValue = new AttributeEnumValue(uniqid('value', true), uniqid('display', true));
        self::assertInstanceOf(AttributeEnumValue::class, $enumValue);
    }

    public function testCanGetValue(): void
    {
        $value = uniqid('value', true);
        $enumValue = new AttributeEnumValue($value, uniqid('display', true));

        self::assertSame($value, $enumValue->getValue());
    }

    public function testCanGetDisplay(): void
    {
        $display = uniqid('display', true);
        $enumValue = new AttributeEnumValue(uniqid('value', true), $display);

        self::assertSame($display, $enumValue->getDisplay());
    }
}
