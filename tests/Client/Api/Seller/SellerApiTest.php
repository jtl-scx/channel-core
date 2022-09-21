<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/23
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Seller;

use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Client\Api\Seller\Request\CreateSellerRequest;
use JTL\SCX\Lib\Channel\Client\Api\Seller\Request\GetSellerIdFromUpdateSessionRequest;
use JTL\SCX\Lib\Channel\Client\Api\Seller\Request\GetSignupSessionDataRequest;
use JTL\SCX\Lib\Channel\Client\Api\Seller\Request\UnlinkSellerRequest;
use JTL\SCX\Lib\Channel\Client\Api\Seller\Request\UpdateSellerRequest;
use JTL\SCX\Lib\Channel\Client\Api\Seller\Response\CreateSellerResponse;
use JTL\SCX\Lib\Channel\Client\Api\Seller\Response\UnlinkSellerResponse;
use JTL\SCX\Lib\Channel\Client\Model\SignupSession;
use JTL\SCX\Lib\Channel\Client\Model\UpdateSeller;
use JTL\SCX\Lib\Channel\Client\Model\UpdateSession;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CreateSellerApiTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Seller
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Seller\SellerApi
 */
class SellerApiTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_send_a_seller_create_request(): void
    {
        $requestMock = $this->createMock(CreateSellerRequest::class);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);

        $client = new SellerApi($apiClientMock);
        $this->assertInstanceOf(CreateSellerResponse::class, $client->create($requestMock));
    }

    /**
     * @test
     */
    public function it_can_send_a_seller_unlink(): void
    {
        $requestMock = $this->createMock(UnlinkSellerRequest::class);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);

        $client = new SellerApi($apiClientMock);
        $this->assertInstanceOf(UnlinkSellerResponse::class, $client->unlink($requestMock));
    }

    /**
     * @test
     */
    public function it_can_request_SellerId_from_UpdateSession(): void
    {
        $sessionId = 'SESSION_ID';
        $client = new SellerApi(
            $apiClientMock = $this->createMock(AuthAwareApiClient::class),
            $deserializer = self::createMock(ChannelApiResponseDeserializer::class)
        );

        $responseMock = $this->createStub(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);

        $apiClientMock->expects($this->once())->method('request')
            ->with(
                self::callback(function (GetSellerIdFromUpdateSessionRequest $request) use ($sessionId) {
                    self::assertEquals($sessionId, $request->getParams()['session']);
                    return true;
                })
            )
            ->willReturn($responseMock);

        $deserializer->expects(self::once())
            ->method('deserialize')
            ->willReturn(new UpdateSession(['sellerId' => 'A_SELLER_ID']));

        $data = $client->getSellerIdFromUpdateSession($sessionId);
        self::assertEquals('A_SELLER_ID', $data->getSellerId());
    }

    /**
     * @test
     */
    public function it_can_send_a_seller_update(): void
    {
        $client = new SellerApi(
            $apiClientMock = $this->createMock(AuthAwareApiClient::class)
        );

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);

        $apiClientMock->expects($this->once())->method('request')
            ->with(self::isInstanceOf(UpdateSellerRequest::class))
            ->willReturn($responseMock);

        $client->update(self::createStub(UpdateSeller::class));
    }

    /**
     * @test
     */
    public function it_can_read_signup_session_data(): void
    {
        $sessionId = 'SESSION_ID';
        $jtlAccountId = 4711;
        $client = new SellerApi(
            $apiClientMock = $this->createMock(AuthAwareApiClient::class),
            $deserializer = self::createMock(ChannelApiResponseDeserializer::class)
        );

        $responseMock = $this->createStub(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);

        $apiClientMock->expects($this->once())->method('request')
            ->with(
                self::callback(function (GetSignupSessionDataRequest $request) use ($sessionId) {
                    self::assertEquals($sessionId, $request->getParams()['session']);
                    return true;
                })
            )
            ->willReturn($responseMock);

        $deserializer->expects(self::once())
            ->method('deserialize')
            ->willReturn(new SignupSession(['jtlAccountId' => $jtlAccountId]));

        $data = $client->getSignupSessionData($sessionId);
        self::assertEquals($jtlAccountId, $data->getJtlAccountId());
    }
}
