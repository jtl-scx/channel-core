<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/03/24
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Response;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Class SendRefundProcessingResultResponseTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Order\Response
 */
#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Order\Response\SendRefundProcessingResultResponse::class)]
class SendRefundProcessingResultResponseTest extends TestCase
{
    #[Test]
    public function it_can_be_created(): void
    {
        $response = new SendRefundProcessingResultResponse(200);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
