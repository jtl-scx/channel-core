<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/5/21
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Request;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use JTL\SCX\Client\Request\ScxApiRequest;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Order\Request\GetInvoiceRequest::class)]
class GetInvoiceRequestTest extends TestCase
{
    #[Test]
    public function it_has_correct_url()
    {
        $sut = new GetInvoiceRequest('foo');
        $this->assertEquals('/v1/channel/order/invoice/{documentId}', $sut->getUrl());
    }

    #[Test]
    public function it_has_documentId_parameter()
    {
        $sut = new GetInvoiceRequest('a_document_id');
        $params = $sut->getParams();
        $this->assertArrayHasKey('documentId', $params);
        $this->assertEquals('a_document_id', $params['documentId']);
    }

    #[Test]
    public function it_use_http_method_GET()
    {
        $sut = new GetInvoiceRequest('foo');
        $this->assertEquals(ScxApiRequest::HTTP_METHOD_GET, $sut->getHttpMethod());
    }
}
