<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-18
 */

namespace MetaData\Attribute;

use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttribute;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttribute
 */
class CategoryAttributeTest extends TestCase
{

    public function testCanBeUsed(): void
    {
        $catId = uniqid('catId', true);
        $attrList = $this->createStub(AttributeList::class);

        $catAttr = new CategoryAttribute($catId, $attrList);

        $this->assertSame($catId, $catAttr->getCategoryId());
        $this->assertSame($attrList, $catAttr->getAttributeList());
    }
}
