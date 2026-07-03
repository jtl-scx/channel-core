<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 9/27/19
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Channel\Response;

use JTL\SCX\Lib\Channel\Client\Model\SalesChannel;
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
        $salesChannel = $this->createStub(SalesChannel::class);
        $statusCode = random_int(1, 1000);

        $response = new GetChannelStatusResponse($salesChannel, $statusCode);

        $this->assertEquals($salesChannel, $response->getSalesChannel());
        $this->assertEquals($statusCode, $response->getStatusCode());
    }
}
