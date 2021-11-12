<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/03/24
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Response;

use PHPUnit\Framework\TestCase;

/**
 * Class SendRefundProcessingResultResponseTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Order\Response
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Order\Response\SendRefundProcessingResultResponse
 */
class SendRefundProcessingResultResponseTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_created(): void
    {
        $response = new SendRefundProcessingResultResponse(200);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
