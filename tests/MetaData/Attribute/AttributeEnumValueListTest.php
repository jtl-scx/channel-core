<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-03-10
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeEnumValueList
 */
class AttributeEnumValueListTest extends TestCase
{

    public function testCanCreateFromValueArray(): void
    {
        $data = [
            'value1',
            'value2'
        ];
        $list = AttributeEnumValueList::fromValueArray($data);

        self::assertInstanceOf(AttributeEnumValueList::class, $list);
        self::assertSame(2, $list->count());
        $value = $list->offsetGet(0);
        self::assertInstanceOf(AttributeEnumValue::class, $value);
        self::assertSame('value1', $value->getValue());
        self::assertNull($value->getDisplay());
        $value = $list->offsetGet(1);
        self::assertInstanceOf(AttributeEnumValue::class, $value);
        self::assertSame('value2', $value->getValue());
        self::assertNull($value->getDisplay());

    }

    public function testCanCreateFromValueArrayReturnNull(): void
    {
        $list = AttributeEnumValueList::fromValueArray(null);
        self::assertNull($list);

    }
}
