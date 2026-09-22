<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2026/09/22
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Request;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use JTL\SCX\Lib\Channel\Client\Model\InvoiceMetaData;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Order\Request\UploadInvoiceDataRequest::class)]
class UploadInvoiceDataRequestTest extends TestCase
{
    #[Test]
    public function it_use_correct_url(): void
    {
        $sut = new UploadInvoiceDataRequest($this->createStub(InvoiceMetaData::class));
        $this->assertEquals('/v1/channel/order/invoice-data', $sut->getUrl());
    }

    #[Test]
    public function it_use_correct_http_method(): void
    {
        $sut = new UploadInvoiceDataRequest($this->createStub(InvoiceMetaData::class));
        $this->assertEquals(UploadInvoiceDataRequest::HTTP_METHOD_POST, $sut->getHttpMethod());
    }

    #[Test]
    public function it_has_the_meta_data_as_its_only_multipart_parameter(): void
    {
        $meta = $this->createStub(InvoiceMetaData::class);
        $meta->method('__toString')->willReturn('meta_data_as_json');
        $sut = new UploadInvoiceDataRequest($meta);

        $parameters = $sut->buildMultipartBody();

        $this->assertCount(1, $parameters);
        $this->assertEquals('invoice', $parameters[0]->getName());
        $this->assertEquals('meta_data_as_json', $parameters[0]->getContent());
    }
}
