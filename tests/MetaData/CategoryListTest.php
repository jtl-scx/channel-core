<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-11-04
 */

namespace JTL\SCX\Lib\Channel\MetaData;

use JTL\Generic\GenericCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class CategoryListTest
 * @package JTL\SCX\Lib\Channel\MetaData
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\CategoryList
 */
class CategoryListTest extends TestCase
{
    public function testIsGenericCollection(): void
    {
        $this->assertInstanceOf(GenericCollection::class, new CategoryList());
    }
}
