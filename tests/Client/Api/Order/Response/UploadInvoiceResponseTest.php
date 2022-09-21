<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/6/21
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Response;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Order\Response\UploadInvoiceResponse
 */
class UploadInvoiceResponseTest extends TestCase
{
    /**
     * @test
     */
    public function it_consider_request_successful_on_http_code_201(): void
    {
        $sut = new UploadInvoiceResponse(201);
        $this->assertTrue($sut->isSuccessful());
    }

    /**
     * @test
     */
    public function it_consider_request_failed_on_http_code_not_equals_201(): void
    {
        $sut = new UploadInvoiceResponse(200);
        $this->assertFalse($sut->isSuccessful());
    }
}
