<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Request;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use JTL\SCX\Lib\Channel\Client\Model\ReturnProcessingResult;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Order\Request\ReturnOrderProcessingResultRequest::class)]
class ReturnOrderProcessingResultRequestTest extends TestCase
{
    #[Test]
    public function it_use_correct_url(): void
    {
        $sut = new ReturnOrderProcessingResultRequest($this->createStub(ReturnProcessingResult::class));
        self::assertEquals('/v1/channel/order/return/processing-result', $sut->getUrl());
    }

    #[Test]
    public function it_use_correct_http_method(): void
    {
        $sut = new ReturnOrderProcessingResultRequest($this->createStub(ReturnProcessingResult::class));
        self::assertEquals('POST', $sut->getHttpMethod());
    }

    #[Test]
    public function it_can_return_body(): void
    {
        $mod = $this->createStub(ReturnProcessingResult::class);
        $mod->method('__toString')->willReturn('foo');
        $sut = new ReturnOrderProcessingResultRequest($mod);
        self::assertEquals('foo', $sut->getBody());
    }
}
