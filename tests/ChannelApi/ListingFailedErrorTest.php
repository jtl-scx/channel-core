<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace ChannelApi;

use JTL\SCX\Lib\Channel\ChannelApi\ListingFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\ChannelApi\ListingFailedError
 */
class ListingFailedErrorTest extends TestCase
{

    public function testCanBeUsed(): void
    {
        $code = uniqid('code', true);
        $message = uniqid('message', true);
        $longMsg = uniqid('longMsg', true);
        $error = new ListingFailedError($code, $message, $longMsg);

        self::assertSame($code, $error->getCode());
        self::assertSame($message, $error->getMessage());
        self::assertSame($longMsg, $error->getLongMessage());
    }
}
