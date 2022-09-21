<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 3/23/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Notification\Request;

use JTL\SCX\Lib\Channel\Client\Model\Notification;
use JTL\SCX\Client\Request\ScxApiRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class NotificationRequestTest
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Notification\Request\NotificationRequest
 */
class NotificationRequestTest extends TestCase
{
    public function testGetUrlIsCorrect()
    {
        $request = new NotificationRequest($this->createStub(Notification::class));
        $this->assertEquals('/v1/channel/notification', $request->getUrl());
    }

    public function testHttpMethodIsPost()
    {
        $request = new NotificationRequest($this->createStub(Notification::class));
        $this->assertEquals(ScxApiRequest::HTTP_METHOD_POST, $request->getHttpMethod());
    }

    public function testHttpRequestBodyIsCreatedFromNotification()
    {
        $notificationMock = $this->createMock(Notification::class);
        $notificationMock->expects($this->once())
            ->method('__toString')
            ->willReturn('{"valid": "json body"}');

        $request = new NotificationRequest($notificationMock);
        $this->assertEquals('{"valid": "json body"}', $request->getBody());
    }
}
