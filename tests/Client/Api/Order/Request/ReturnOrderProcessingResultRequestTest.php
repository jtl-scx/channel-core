<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Request;

use JTL\SCX\Lib\Channel\Client\Model\ReturnProcessingResult;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Order\Request\ReturnOrderProcessingResultRequest
 */
class ReturnOrderProcessingResultRequestTest extends TestCase
{
    /**
     * @test
     */
    public function it_use_correct_url(): void
    {
        $sut = new ReturnOrderProcessingResultRequest($this->createStub(ReturnProcessingResult::class));
        self::assertEquals('/v1/channel/order/return/processing-result', $sut->getUrl());
    }

    /**
     * @test
     */
    public function it_use_correct_http_method(): void
    {
        $sut = new ReturnOrderProcessingResultRequest($this->createStub(ReturnProcessingResult::class));
        self::assertEquals('POST', $sut->getHttpMethod());
    }

    /**
     * @test
     */
    public function it_can_return_body(): void
    {
        $mod = $this->createStub(ReturnProcessingResult::class);
        $mod->method('__toString')->willReturn('foo');
        $sut = new ReturnOrderProcessingResultRequest($mod);
        self::assertEquals('foo', $sut->getBody());
    }
}
