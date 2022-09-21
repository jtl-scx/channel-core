<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2020/04/27
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Report;

use JTL\SCX\Client\Api\AuthAwareApiClient;
use PHPUnit\Framework\TestCase;
use JTL\SCX\Lib\Channel\Client\Api\Report\Request\SendReportRequest;
use JTL\SCX\Lib\Channel\Client\Api\Report\Response\SendReportResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ReportApiTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Report
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Report\ReportApi
 */
class ReportApiTest extends TestCase
{
    public function testSendReport(): void
    {
        $requestMock = $this->createMock(SendReportRequest::class);

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);
        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);

        $client = new ReportApi($apiClientMock);
        $this->assertInstanceOf(SendReportResponse::class, $client->sendReport($requestMock));
    }
}
