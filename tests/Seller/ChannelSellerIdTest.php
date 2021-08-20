<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Seller;

use JTL\SCX\Lib\Channel\Core\Log\Context\SellerIdContext;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Seller\ChannelSellerId
 */
class ChannelSellerIdTest extends TestCase
{
    public function testCanGetId(): void
    {
        $sellerId = uniqid('sellerId', true);
        $channelSellerId = new ChannelSellerId($sellerId);
        self::assertSame($sellerId, $channelSellerId->getId());
    }

    public function testCanCreateContextInstance(): void
    {
        $sellerId = uniqid('sellerId', true);
        $channelSellerId = new ChannelSellerId($sellerId);

        self::assertInstanceOf(SellerIdContext::class, $channelSellerId->createContextInstance());
    }

    public function testCanBeUsedAsString(): void
    {
        $sellerId = uniqid('sellerId', true);
        $channelSellerId = new ChannelSellerId($sellerId);
        self::assertSame($sellerId, (string)$channelSellerId);
    }
}
