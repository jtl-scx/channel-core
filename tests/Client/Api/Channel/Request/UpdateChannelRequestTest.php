<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/23
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Channel\Request;

use PHPUnit\Framework\Attributes\CoversClass;
use JTL\SCX\Lib\Channel\Client\Model\ChannelUpdate;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateChannelRequestTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Channel\Request
 */
#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Channel\Request\UpdateChannelRequest::class)]
class UpdateChannelRequestTest extends TestCase
{
    public function testCanBeCreatedAndUsed(): void
    {
        $bodyStr = uniqid('body', true);

        $channelUpdateMock = $this->createMock(ChannelUpdate::class);
        $channelUpdateMock->expects($this->once())->method('__toString')->willReturn($bodyStr);

        $request = new UpdateChannelRequest($channelUpdateMock);

        $this->assertSame($bodyStr, $request->getBody());
        $this->assertSame('PATCH', $request->getHttpMethod());
        $this->assertSame('/v1/channel', $request->getUrl());
    }
}
