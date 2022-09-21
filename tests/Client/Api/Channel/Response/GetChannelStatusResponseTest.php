<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 9/27/19
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Channel\Response;

use JTL\SCX\Lib\Channel\Client\Model\SalesChannelData;
use PHPUnit\Framework\TestCase;

/**
 * Class GetChannelStatusResponseTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Channel\Response
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Channel\Response\GetChannelStatusResponse
 */
class GetChannelStatusResponseTest extends TestCase
{
    public function testCanGetData(): void
    {
        $salesChannelData = $this->createStub(SalesChannelData::class);
        $statusCode = random_int(1, 1000);

        $response = new GetChannelStatusResponse($salesChannelData, $statusCode);

        $this->assertEquals($salesChannelData, $response->getSalesChannelData());
        $this->assertEquals($statusCode, $response->getStatusCode());
    }
}
