<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Response;

use JTL\SCX\Client\Response\AbstractResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Order\Response\ReturnOrderProcessingResultResponse
 */
class ReturnOrderProcessingResultResponseTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_successful_of_http_201(): void
    {
        $sut = new ReturnOrderProcessingResultResponse(201);
        self::assertTrue($sut->isSuccessful());

        $sut = new ReturnOrderProcessingResultResponse(200);
        self::assertFalse($sut->isSuccessful());
    }
}
