<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\AcceptCancellationRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\CreateOrderRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\DenyCancellationRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\GetInvoiceRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\RequestOrderCancellationRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\ReturnOrderProcessingResultRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\ReturnOrderRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\SendRefundProcessingResultRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\UpdateOrderAddressRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\UpdateOrderStatusRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\UploadInvoiceRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\AbstractOrderResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\AcceptCancellationResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\CreateOrdersResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\DenyCancellationResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\InvoiceResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\RequestOrderCancellationResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\ReturnOrderProcessingResultResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\ReturnOrderResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\SendRefundProcessingResultResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\UpdateOrderAddressResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\UpdateOrderStatusResponse;
use JTL\SCX\Lib\Channel\Client\Api\Order\Response\UploadInvoiceResponse;
use JTL\SCX\Lib\Channel\Client\Model\ErrorResponseList;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Client\Response\AbstractResponse;
use Psr\Http\Message\ResponseInterface;

class OrderApi
{
    private AuthAwareApiClient $client;
    private ChannelApiResponseDeserializer $responseDeserializer;

    public function __construct(AuthAwareApiClient $client, ChannelApiResponseDeserializer $responseDeserializer = null)
    {
        $this->client = $client;
        $this->responseDeserializer = $responseDeserializer ?? new ChannelApiResponseDeserializer();
    }

    /**
     * @param CreateOrderRequest $request
     * @return CreateOrdersResponse
     * @throws RequestFailedException
     * @throws GuzzleException
     */
    public function create(CreateOrderRequest $request): CreateOrdersResponse
    {
        $response = $this->client->request($request);
        return $this->createResponse($response, CreateOrdersResponse::class);
    }

    /**
     * @param UpdateOrderStatusRequest $request
     * @return UpdateOrderStatusResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function updateStatus(UpdateOrderStatusRequest $request): UpdateOrderStatusResponse
    {
        $response = $this->client->request($request);
        return $this->createResponse($response, UpdateOrderStatusResponse::class);
    }

    /**
     * @param UpdateOrderAddressRequest $request
     * @return UpdateOrderAddressResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function updateAddress(UpdateOrderAddressRequest $request): UpdateOrderAddressResponse
    {
        $response = $this->client->request($request);
        return $this->createResponse($response, UpdateOrderAddressResponse::class);
    }

    /**
     * @param RequestOrderCancellationRequest $request
     * @return RequestOrderCancellationResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function requestOrderCancellation(RequestOrderCancellationRequest $request): RequestOrderCancellationResponse
    {
        $response = $this->client->request($request);
        return $this->createResponse($response, RequestOrderCancellationResponse::class);
    }

    /**
     * @param AcceptCancellationRequest $request
     * @return AcceptCancellationResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function acceptOrderCancellation(AcceptCancellationRequest $request): AcceptCancellationResponse
    {
        $response = $this->client->request($request);
        return new AcceptCancellationResponse($response->getStatusCode());
    }

    /**
     * @param DenyCancellationRequest $request
     * @return DenyCancellationResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function denyOrderCancellation(DenyCancellationRequest $request): DenyCancellationResponse
    {
        $response = $this->client->request($request);
        return new DenyCancellationResponse($response->getStatusCode());
    }

    /**
     * @param GetInvoiceRequest $request
     * @return InvoiceResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function getInvoice(GetInvoiceRequest $request): InvoiceResponse
    {
        $response = $this->client->request($request);
        return new InvoiceResponse($response->getStatusCode(), $response->getBody());
    }

    /**
     * @param UploadInvoiceRequest $request
     * @return UploadInvoiceResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function uploadInvoice(UploadInvoiceRequest $request): UploadInvoiceResponse
    {
        $response = $this->client->request($request);
        return new UploadInvoiceResponse($response->getStatusCode());
    }

    /**
     * @param SendRefundProcessingResultRequest $request
     * @return SendRefundProcessingResultResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function sendRefundProcessingResult(SendRefundProcessingResultRequest $request): SendRefundProcessingResultResponse
    {
        $response = $this->client->request($request);
        return new SendRefundProcessingResultResponse($response->getStatusCode());
    }

    /**
     * @param \JTL\SCX\Lib\Channel\Client\Api\Order\Request\ReturnOrderRequest $request
     * @return \JTL\SCX\Lib\Channel\Client\Api\Order\Response\ReturnOrderResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JTL\SCX\Client\Exception\RequestFailedException
     */
    public function sendOrderReturn(ReturnOrderRequest $request): ReturnOrderResponse
    {
        $response = $this->client->request($request);
        return new ReturnOrderResponse($response->getStatusCode());
    }

    /**
     * @param ReturnOrderProcessingResultRequest $request
     * @return \JTL\SCX\Lib\Channel\Client\Api\Order\Response\ReturnOrderProcessingResultResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JTL\SCX\Client\Exception\RequestFailedException
     */
    public function sendOrderReturnProcessingResult(ReturnOrderProcessingResultRequest $request): ReturnOrderProcessingResultResponse
    {
        $response = $this->client->request($request);
        return new ReturnOrderProcessingResultResponse($response->getStatusCode());
    }


    /**
     * @param ResponseInterface $apiResponse
     * @param string $responseClass
     * @return AbstractOrderResponse|CreateOrdersResponse|UpdateOrderStatusResponse|UpdateOrderAddressResponse|RequestOrderCancellationResponse
     */
    private function createResponse(ResponseInterface $apiResponse, string $responseClass): AbstractOrderResponse
    {
        $responseBody = trim((string)$apiResponse->getBody()->getContents());
        if (strlen($responseBody) > 0) {
            /** @var ErrorResponseList $errorResponse */
            $errorResponse = $this->responseDeserializer->deserializeObject($responseBody, ErrorResponseList::class);
            $errorList = $errorResponse->getErrorList();
        }

        return new $responseClass($apiResponse->getStatusCode(), $errorList ?? null);
    }
}
