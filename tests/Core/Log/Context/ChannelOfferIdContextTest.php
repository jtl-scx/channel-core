<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use JTL\SCX\Lib\Channel\Core\Log\Context\ChannelOfferIdContext;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Log\Context\ChannelOfferIdContext
 */
class ChannelOfferIdContextTest extends TestCase
{
    public function testCanBeUsed(): void
    {
        $channelOfferId = uniqid('channelOfferId', true);
        $context = new ChannelOfferIdContext($channelOfferId);

        $record = ['foo' => 'bar'];
        self::assertSame(
            $record + ['extra' => ['channelOffer' => ['id' => $channelOfferId], 'label' => ['offer']]],
            $context($record)
        );
    }
}
