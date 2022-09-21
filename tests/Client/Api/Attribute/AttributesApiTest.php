<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-13
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Attribute;

use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\CreateCategoryAttributesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\CreateGlobalAttributesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\CreateSellerAttributesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\DeleteCategoryAttributesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\DeleteGlobalAttributeRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AttributesApiTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Attribute\AttributesApi
 */
class AttributesApiTest extends TestCase
{
    public function testCreateSellerAttributes()
    {
        $status = 201;
        $requestMock = $this->createMock(CreateSellerAttributesRequest::class);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn($status);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);

        $client = new AttributesApi($apiClientMock);
        $response = $client->createSellerAttributes($requestMock);

        $this->assertSame($status, $response->getStatusCode());
    }

    public function testDeleteGlobalAttribute()
    {
        $status = 201;
        $requestMock = $this->createMock(DeleteGlobalAttributeRequest::class);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn($status);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);

        $client = new AttributesApi($apiClientMock);
        $response = $client->deleteGlobalAttribute($requestMock);

        $this->assertSame($status, $response->getStatusCode());
    }

    public function testCreateGlobalAttributes()
    {
        $status = 201;
        $requestMock = $this->createMock(CreateGlobalAttributesRequest::class);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn($status);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);

        $client = new AttributesApi($apiClientMock);
        $response = $client->createGlobalAttributes($requestMock);

        $this->assertSame($status, $response->getStatusCode());
    }

    public function testCreateCategoryAttributes()
    {
        $status = 201;
        $requestMock = $this->createMock(CreateCategoryAttributesRequest::class);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn($status);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);

        $client = new AttributesApi($apiClientMock);
        $response = $client->createCategoryAttributes($requestMock);

        $this->assertSame($status, $response->getStatusCode());
    }

    public function testItSendCategoryAttributeDeleteCall(): void
    {
        $status = 201;
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn($status);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')
            ->with(self::isInstanceOf(DeleteCategoryAttributesRequest::class))
            ->willReturn($responseMock);

        $client = new AttributesApi($apiClientMock);
        $response = $client->deleteCategoryAttributes('A_CATEGORY_ID');

        $this->assertSame($status, $response->getStatusCode());
    }
}
