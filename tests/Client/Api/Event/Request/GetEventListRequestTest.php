<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-13
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Event\Request;

use PHPUnit\Framework\TestCase;

/**
 * Class GetEventListRequestTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Event\Request
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Event\Request\GetEventListRequest
 */
class GetEventListRequestTest extends TestCase
{
    public function testCanGetUrlAndHttpMethod()
    {
        $request = new GetEventListRequest();
        $this->assertSame('/v1/channel/event', $request->getUrl());
        $this->assertSame('GET', $request->getHttpMethod());
    }
}
