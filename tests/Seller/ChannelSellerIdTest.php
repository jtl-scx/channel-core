<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Seller;

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

    public function testCanBeUsedAsString(): void
    {
        $sellerId = uniqid('sellerId', true);
        $channelSellerId = new ChannelSellerId($sellerId);
        self::assertSame($sellerId, (string)$channelSellerId);
    }

    public function testCanLog(): void
    {
        $sellerId = uniqid('sellerId', true);
        $channelSellerId = new ChannelSellerId($sellerId);

        $record = ['foo' => 'bar'];
        self::assertSame(
            $record + ['extra' => ['seller' => ['id' => $sellerId], 'label' => ['seller']]],
            $channelSellerId($record)
        );
    }
}
