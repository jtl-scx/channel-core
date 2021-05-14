<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-18
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeList
 */
class CategoryAttributeListTest extends TestCase
{
    public function testCanBeUsed(): void
    {
        $list = new CategoryAttributeList();
        self::assertSame(0, $list->count());
        $list->add($this->createStub(CategoryAttribute::class));
        self::assertSame(1, $list->count());
    }

    public function testCanAddByAttibuteList(): void
    {
        $catId = uniqid('catId', true);
        $attrList = $this->createStub(AttributeList::class);

        $list = new CategoryAttributeList();
        $list->addAttributeList($catId, $attrList);

        self::assertSame(1, $list->count());
        $catAttr = $list->offsetGet(0);
        self::assertSame($catId, $catAttr->getCategoryId());
        self::assertSame($attrList, $catAttr->getAttributeList());
    }

    public function testFailsOnWrongType(): void
    {
        $list = new CategoryAttributeList();
        $this->expectException(InvalidArgumentException::class);
        $list->add(new stdClass());
    }
}
