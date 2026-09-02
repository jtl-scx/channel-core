<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\MetaData\ShippingAttribute;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\MetaData\ShippingAttribute\DefaultGlobalShippingAttributeLoader
 */
class DefaultGlobalShippingAttributeLoaderTest extends TestCase
{
    public function testReturnsEmptyListByDefault(): void
    {
        $sut = new DefaultGlobalShippingAttributeLoader();

        $this->assertSame([], $sut->load());
    }
}
