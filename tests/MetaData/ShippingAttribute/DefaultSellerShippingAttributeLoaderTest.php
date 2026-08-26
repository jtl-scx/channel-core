<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\MetaData\ShippingAttribute;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\MetaData\ShippingAttribute\DefaultSellerShippingAttributeLoader
 */
class DefaultSellerShippingAttributeLoaderTest extends TestCase
{
    public function testReturnsEmptyListByDefault(): void
    {
        $sut = new DefaultSellerShippingAttributeLoader();

        $this->assertSame([], $sut->fetchAll(uniqid('sellerId', true)));
    }
}
