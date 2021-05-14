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
    public function testCanCreateFromScalarArray(): void
    {
        $data = [
            'value1',
            'value2'
        ];
        $list = AttributeEnumValueList::fromScalarArray($data);

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

    /**
     * @test
     */
    public function it_can_be_created_from_array(): void
    {
        $data = [
            ['value' => 1, 'display' => '123'],
            ['value' => 'FOO', 'display' => '456'],
        ];

        $sut = AttributeEnumValueList::fromArray($data);

        self::assertArrayHasKey(0, $sut);
        self::assertEquals("1", $sut[0]->getValue());
        self::assertEquals("123", $sut[0]->getDisplay());

        self::assertArrayHasKey(1, $sut);
        self::assertEquals("FOO", $sut[1]->getValue());
        self::assertEquals("456", $sut[1]->getDisplay());
    }


    public function testCanCreateFromValueArrayReturnNull(): void
    {
        $list = AttributeEnumValueList::fromScalarArray(null);
        self::assertNull($list);
    }
}
