<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-08-17
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Meta;

use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\Meta\Request\CreateShippingRulesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Meta\Response\CreateShippingRulesResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Meta\ShippingRulesApi
 */
class ShippingRulesApiTest extends TestCase
{
    public function testCanCreatePaymentRules(): void
    {
        $requestMock = $this->createMock(CreateShippingRulesRequest::class);

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(201);
        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);

        $client = new ShippingRulesApi($apiClientMock);
        $this->assertInstanceOf(CreateShippingRulesResponse::class, $client->create($requestMock));
    }
}
