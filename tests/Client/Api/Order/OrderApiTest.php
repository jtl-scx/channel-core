<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/23
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order;

use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\AcceptCancellationRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\CreateOrderRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\DenyCancellationRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\GetInvoiceRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\RequestOrderCancellationRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\ReturnOrderRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\ReturnOrderProcessingResultRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\SendRefundProcessingResultRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\UpdateOrderAddressRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\UpdateOrderStatusRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\UploadInvoiceRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\AbstractOrderResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\CreateOrdersResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\InvoiceResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\RequestOrderCancellationResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\ReturnOrderResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\ReturnOrderProcessingResultResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\SendRefundProcessingResultResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\UpdateOrderAddressResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\UpdateOrderStatusResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\UploadInvoiceResponse;
use JTL\SCX\Lib\Channel\Client\Model\ErrorResponseList;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class CreateOrdersApiTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Order
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Order\OrderApi
 */
class OrderApiTest extends TestCase
{
    public function testCreate(): void
    {
        $requestMock = $this->createMock(CreateOrderRequest::class);
        $streamMock = $this->createMock(StreamInterface::class);
        $streamMock->method('getContents')->willReturn(null);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);
        $responseMock->method('getBody')->willReturn($streamMock);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);

        $client = new OrderApi($apiClientMock);
        $this->assertInstanceOf(CreateOrdersResponse::class, $client->create($requestMock));
    }

    public function testCanUpdateStatus(): void
    {
        $requestMock = $this->createMock(UpdateOrderStatusRequest::class);
        $streamMock = $this->createMock(StreamInterface::class);
        $streamMock->method('getContents')->willReturn(null);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);
        $responseMock->method('getBody')->willReturn($streamMock);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);

        $client = new OrderApi($apiClientMock);
        $this->assertInstanceOf(UpdateOrderStatusResponse::class, $client->updateStatus($requestMock));
    }

    public function testCanUpdateAddress(): void
    {
        $requestMock = $this->createMock(UpdateOrderAddressRequest::class);
        $streamMock = $this->createMock(StreamInterface::class);
        $streamMock->method('getContents')->willReturn(null);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);
        $responseMock->method('getBody')->willReturn($streamMock);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);

        $client = new OrderApi($apiClientMock);
        $this->assertInstanceOf(UpdateOrderAddressResponse::class, $client->updateAddress($requestMock));
    }

    public function testCanRequestOrderCancellation(): void
    {
        $request = $this->createStub(RequestOrderCancellationRequest::class);
        $streamMock = $this->createMock(StreamInterface::class);
        $streamMock->method('getContents')->willReturn(null);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);
        $responseMock->method('getBody')->willReturn($streamMock);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($request)->willReturn($responseMock);

        $client = new OrderApi($apiClientMock);
        $this->assertInstanceOf(RequestOrderCancellationResponse::class, $client->requestOrderCancellation($request));
    }

    public function testCanRetrieveResponseWithError(): void
    {
        $errorJson = '{"foo": "bar"}';

        $requestMock = $this->createMock(CreateOrderRequest::class);
        $streamMock = $this->createMock(StreamInterface::class);
        $streamMock->method('getContents')->willReturn($errorJson);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);
        $responseMock->method('getBody')->willReturn($streamMock);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);

        $errorResponse = $this->createMock(ErrorResponseList::class);
        $errorResponse->expects($this->atLeastOnce())->method('getErrorList')->willReturn([]);
        $deserializerMock = $this->createMock(ChannelApiResponseDeserializer::class);
        $deserializerMock->expects($this->once())->method('deserializeObject')->willReturn($errorResponse);

        $client = new OrderApi($apiClientMock, $deserializerMock);
        $response = $client->create($requestMock);
        $this->assertInstanceOf(AbstractOrderResponse::class, $response);
        $this->assertTrue($response->hasError());
    }

    public function testCanSendAcceptCancellationRequest(): void
    {
        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $deserializerStub = $this->createStub(ChannelApiResponseDeserializer::class);

        $sut = new OrderApi($apiClientMock, $deserializerStub);

        $request = new AcceptCancellationRequest("A_SELLER", "A_ID");
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(201);

        $apiClientMock->expects($this->once())->method('request')
            ->with($request)
            ->willReturn($responseMock);

        $response = $sut->acceptOrderCancellation($request);
        $this->assertTrue($response->isSuccessful());
    }

    public function testCanSendDenyCancellationRequest(): void
    {
        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $deserializerStub = $this->createStub(ChannelApiResponseDeserializer::class);

        $sut = new OrderApi($apiClientMock, $deserializerStub);

        $request = new DenyCancellationRequest("A_SELLER", "A_ID", "Reason");
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(201);

        $apiClientMock->expects($this->once())->method('request')
            ->with($request)
            ->willReturn($responseMock);

        $response = $sut->denyOrderCancellation($request);
        $this->assertTrue($response->isSuccessful());
    }

    public function testItCanDownloadAInvoiceSuccessfully(): void
    {
        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $deserializerStub = $this->createStub(ChannelApiResponseDeserializer::class);

        $client = new OrderApi($apiClientMock, $deserializerStub);

        $testDocument = $this->createStub(StreamInterface::class);

        $request = $this->createMock(GetInvoiceRequest::class);

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);
        $responseMock->method('getBody')->willReturn($testDocument);

        $apiClientMock->expects($this->once())->method('request')->with($request)->willReturn($responseMock);

        $response = $client->getInvoice($request);

        $this->assertInstanceOf(InvoiceResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame($testDocument, $response->getDocument());
    }

    public function testItCanUploadAInvoiceSuccessfully(): void
    {
        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $deserializerStub = $this->createStub(ChannelApiResponseDeserializer::class);

        $client = new OrderApi($apiClientMock, $deserializerStub);

        $request = $this->createMock(UploadInvoiceRequest::class);

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(201);

        $apiClientMock->expects($this->once())->method('request')->with($request)->willReturn($responseMock);

        $response = $client->uploadInvoice($request);

        $this->assertInstanceOf(UploadInvoiceResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
    }

    public function testItCanSendRefundProcessingResultSuccessfully(): void
    {
        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $deserializerStub = $this->createStub(ChannelApiResponseDeserializer::class);

        $client = new OrderApi($apiClientMock, $deserializerStub);

        $request = $this->createMock(SendRefundProcessingResultRequest::class);

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(201);

        $apiClientMock->expects($this->once())->method('request')->with($request)->willReturn($responseMock);

        $response = $client->sendRefundProcessingResult($request);

        $this->assertInstanceOf(SendRefundProcessingResultResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
    }

    public function testCanReturnOrder(): void
    {
        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $deserializerStub = $this->createStub(ChannelApiResponseDeserializer::class);

        $client = new OrderApi($apiClientMock, $deserializerStub);

        $request = $this->createMock(ReturnOrderRequest::class);

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(201);

        $apiClientMock->expects($this->once())->method('request')->with($request)->willReturn($responseMock);

        $response = $client->sendOrderReturn($request);

        $this->assertInstanceOf(ReturnOrderResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
    }

    public function testItCanSendOrderReturnProcessingResult(): void
    {
        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $deserializerStub = $this->createStub(ChannelApiResponseDeserializer::class);

        $sut = new OrderApi($apiClientMock, $deserializerStub);

        $request = $this->createMock(ReturnOrderProcessingResultRequest::class);

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(201);

        $apiClientMock->expects($this->once())->method('request')->with($request)->willReturn($responseMock);

        $response = $sut->sendOrderReturnProcessingResult($request);

        $this->assertInstanceOf(ReturnOrderProcessingResultResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
    }
}
