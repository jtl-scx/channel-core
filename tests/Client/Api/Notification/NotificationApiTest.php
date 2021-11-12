<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 3/23/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Notification;

use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\Notification\Request\NotificationRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class NotificationApiTest
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Notification\NotificationApi
 */
class NotificationApiTest extends TestCase
{
    public function testCanSendRequest()
    {
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->expects($this->once())->method('getStatusCode')->willReturn(201);

        $clientMock = $this->createMock(AuthAwareApiClient::class);
        $clientMock->expects($this->once())->method('request')->willReturn($responseMock);

        $api = new NotificationApi($clientMock);
        $response = $api->send($this->createStub(NotificationRequest::class));
        $this->assertTrue($response->isSuccessful());
    }
}
