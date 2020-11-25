<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace Core\Log\Context;

use JTL\SCX\Lib\Channel\Core\Log\Context\ChannelOrderIdContext;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Log\Context\ChannelOrderIdContext
 */
class ChannelOrderIdContextTest extends TestCase
{

    public function testCanBeUsed(): void
    {
        $channelOrderId = uniqid('channelOrderId', true);
        $context = new ChannelOrderIdContext($channelOrderId);

        $record = ['foo' => 'bar'];
        self::assertSame($record + ['channelOrder' => ['id' => $channelOrderId]], $context($record));
    }
}
