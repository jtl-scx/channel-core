<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Response;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Order\Response\ReturnOrderResponse
 */
class ReturnOrderResponseTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_successful_on_http201(): void
    {
        $sut = new ReturnOrderResponse(201);
        self::assertTrue($sut->isSuccessful());

        $sut = new ReturnOrderResponse(200);
        self::assertFalse($sut->isSuccessful());
    }
}
