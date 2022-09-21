<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-13
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Channel;

use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\Channel\Request\GetChannelStatusRequest;
use JTL\SCX\Lib\Channel\Client\Api\Channel\Request\UpdateChannelRequest;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Client\Model\ChannelStatus;
use JTL\SCX\Lib\Channel\Client\Model\SalesChannelData;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ChannelApiTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Channel
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Channel\ChannelApi
 */
class ChannelApiTest extends TestCase
{
    public function testUpdate()
    {
        $status = 201;
        $requestMock = $this->createMock(UpdateChannelRequest::class);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn($status);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);

        $serializerMock = $this->createMock(ChannelApiResponseDeserializer::class);

        $client = new ChannelApi($apiClientMock, $serializerMock);
        $response = $client->update($requestMock);

        $this->assertSame($status, $response->getStatusCode());
    }

    public function testGetStatus()
    {
        $status = 201;
        $requestMock = $this->createMock(GetChannelStatusRequest::class);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn($status);

        $channelData = $this->createMock(SalesChannelData::class);
        $channelStatusMock = $this->createMock(ChannelStatus::class);
        $channelStatusMock->expects($this->once())->method('getChannel')->willReturn($channelData);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);
        $serializerMock = $this->createMock(ChannelApiResponseDeserializer::class);
        $serializerMock->expects($this->once())->method('deserialize')->with($responseMock)->willReturn($channelStatusMock);

        $client = new ChannelApi($apiClientMock, $serializerMock);
        $response = $client->getStatus($requestMock);

        $this->assertSame($status, $response->getStatusCode());
        $this->assertSame($channelData, $response->getSalesChannelData());
    }
}
