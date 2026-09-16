<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Response;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Order\Response\ReturnOrderProcessingResultResponse::class)]
class ReturnOrderProcessingResultResponseTest extends TestCase
{
    #[Test]
    public function it_is_successful_of_http_201(): void
    {
        $sut = new ReturnOrderProcessingResultResponse(201);
        self::assertTrue($sut->isSuccessful());

        $sut = new ReturnOrderProcessingResultResponse(200);
        self::assertFalse($sut->isSuccessful());
    }
}
