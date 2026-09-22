<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2026/09/22
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Response;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Order\Response\UploadInvoiceDataResponse::class)]
class UploadInvoiceDataResponseTest extends TestCase
{
    #[Test]
    public function it_consider_request_successful_on_http_code_201(): void
    {
        $sut = new UploadInvoiceDataResponse(201);
        $this->assertTrue($sut->isSuccessful());
    }

    #[Test]
    public function it_consider_request_failed_on_http_code_not_equals_201(): void
    {
        $sut = new UploadInvoiceDataResponse(400);
        $this->assertFalse($sut->isSuccessful());
    }
}
