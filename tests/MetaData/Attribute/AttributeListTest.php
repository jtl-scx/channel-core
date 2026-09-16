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
 * Class AttributeListTest
 * @package MetaData\Attribute
 */
#[CoversClass(\JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList::class)]
class AttributeListTest extends TestCase
{
    public function testCanCreateInstance(): void
    {
        $this->assertInstanceOf(AttributeList::class, new AttributeList());
    }
}
