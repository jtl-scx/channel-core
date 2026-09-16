<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-13
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Channel;

use PHPUnit\Framework\Attributes\CoversClass;
use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\Channel\Request\GetChannelStatusRequest;
use JTL\SCX\Lib\Channel\Client\Api\Channel\Request\UpdateChannelRequest;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Client\Model\ChannelStatus;
use JTL\SCX\Lib\Channel\Client\Model\SalesChannel;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ChannelApiTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Channel
 */
#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Channel\ChannelApi::class)]
class ChannelApiTest extends TestCase
{
    public function testUpdate()
    {
        $status = 201;
        $requestMock = $this->createStub(UpdateChannelRequest::class);
        $responseMock = $this->createStub(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn($status);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);

        $serializerMock = $this->createStub(ChannelApiResponseDeserializer::class);

        $client = new ChannelApi($apiClientMock, $serializerMock);
        $response = $client->update($requestMock);

        $this->assertSame($status, $response->getStatusCode());
    }

    public function testGetStatus()
    {
        $status = 201;
        $requestMock = $this->createStub(GetChannelStatusRequest::class);
        $responseMock = $this->createStub(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn($status);

        $channelData = $this->createStub(SalesChannel::class);
        $channelStatusMock = $this->createMock(ChannelStatus::class);
        $channelStatusMock->expects($this->once())->method('getChannel')->willReturn($channelData);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);
        $serializerMock = $this->createMock(ChannelApiResponseDeserializer::class);
        $serializerMock->expects($this->once())->method('deserialize')->with($responseMock)->willReturn($channelStatusMock);

        $client = new ChannelApi($apiClientMock, $serializerMock);
        $response = $client->getStatus($requestMock);

        $this->assertSame($status, $response->getStatusCode());
        $this->assertSame($channelData, $response->getSalesChannel());
    }
}
