<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace MetaData\Attribute;

use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeList;
use PHPUnit\Framework\TestCase;

/**
 * Class CategoryAttributeListTest
 * @package MetaData\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeList
 */
class CategoryAttributeListTest extends TestCase
{
    public function testCanCreateInstance(): void
    {
        $this->assertInstanceOf(CategoryAttributeList::class, new CategoryAttributeList());
    }
}
