<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/23
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Price;

use JTL\SCX\Client\Api\AuthAwareApiClient;
use PHPUnit\Framework\TestCase;
use JTL\SCX\Lib\Channel\Client\Api\Price\Request\CreatePriceTypeRequest;
use JTL\SCX\Lib\Channel\Client\Api\Price\Response\CreatePriceTypeResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CreatePriceTypeApiTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Price
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Price\PriceApi
 */
class PriceApiTest extends TestCase
{
    public function testCreatePriceType(): void
    {
        $requestMock = $this->createMock(CreatePriceTypeRequest::class);

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);
        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);

        $client = new PriceApi($apiClientMock);
        $this->assertInstanceOf(CreatePriceTypeResponse::class, $client->create($requestMock));
    }
}
