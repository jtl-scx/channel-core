<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Response;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Order\Response\UpdateOrderAddressResponse
 */
class UpdateOrderAddressResponseTest extends TestCase
{
    /**
     * @test
     */
    public function it_consider_request_successful_on_http_code_201(): void
    {
        $sut = new UpdateOrderAddressResponse(201);
        $this->assertTrue($sut->isSuccessful());
    }

    /**
     * @test
     */
    public function it_consider_request_failed_on_http_code_not_equals_201(): void
    {
        $sut = new UpdateOrderAddressResponse(200);
        $this->assertFalse($sut->isSuccessful());
    }
}
