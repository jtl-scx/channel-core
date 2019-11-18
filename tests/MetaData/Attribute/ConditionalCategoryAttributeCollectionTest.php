<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace MetaData\Attribute;

use JTL\SCX\Lib\Channel\MetaData\Attribute\ConditionalCategoryAttributeCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class ConditionalCategoryAttributeCollectionTest
 * @package MetaData\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\ConditionalCategoryAttributeCollection
 */
class ConditionalCategoryAttributeCollectionTest extends TestCase
{
    public function testCanCreateCollection(): void
    {
        $this->assertInstanceOf(ConditionalCategoryAttributeCollection::class, new ConditionalCategoryAttributeCollection());
    }
}
