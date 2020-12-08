<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace Core\Log\Context;

use JTL\SCX\Lib\Channel\Core\Log\Context\SellerIdContext;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use phpDocumentor\Reflection\DocBlock\Tags\See;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Log\Context\SellerIdContext
 */
class SellerIdContextTest extends TestCase
{
    public function testCanBeUsed(): void
    {
        $sellerIdStr = uniqid('sellerIdStr', true);
        $sellerId  = $this->createMock(ChannelSellerId::class);
        $sellerId->expects(self::once())->method('getId')->willReturn($sellerIdStr);
        $context = new SellerIdContext($sellerId);

        $record = ['foo' => 'bar'];
        self::assertSame($record + ['seller' => ['id' => $sellerIdStr]], $context($record));
    }
}
