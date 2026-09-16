<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * Class ConditionalAttributeCollectionTest
 * @package MetaData\Attribute
 */
#[CoversClass(\JTL\SCX\Lib\Channel\MetaData\Attribute\ConditionalAttributeList::class)]
class ConditionalAttributeListTest extends TestCase
{
    public function testCanCreateCollection(): void
    {
        $this->assertInstanceOf(ConditionalAttributeList::class, new ConditionalAttributeList());
    }
}
