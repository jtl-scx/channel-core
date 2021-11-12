<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/03/23
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Request;

use JTL\SCX\Lib\Channel\Client\Model\RefundProcessingResult;
use PHPUnit\Framework\TestCase;

/**
 * Class SendRefundProcessingResultRequestTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Order\Request
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Order\Request\SendRefundProcessingResultRequest
 */
class SendRefundProcessingResultRequestTest extends TestCase
{
    public function testCanBeCreatedAndUsed(): void
    {
        $result = $this->createMock(RefundProcessingResult::class);

        $request = new SendRefundProcessingResultRequest($result);

        $this->assertSame($result, $request->getRefundProcessingResult());
        $this->assertSame((string)$result, $request->getBody());
        $this->assertSame('POST', $request->getHttpMethod());
        $this->assertSame('/v1/channel/order/refund/processing-result', $request->getUrl());
    }
}
